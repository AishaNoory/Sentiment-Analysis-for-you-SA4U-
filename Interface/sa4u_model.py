import pandas as pd
import nltk
from nltk.sentiment.vader import SentimentIntensityAnalyzer
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.model_selection import train_test_split
from sklearn.svm import SVC
from sklearn.metrics import classification_report
import json
from collections import Counter
from datetime import datetime

# Ensure necessary NLTK data is downloaded
nltk.download('vader_lexicon')
nltk.download('stopwords')

# Define a function to clean text data
def clean(text):
    from nltk.corpus import stopwords
    import re
    import string

    stop_words = set(stopwords.words('english'))
    text = text.lower()
    text = re.sub('\[.*?\]', '', text)
    text = re.sub('https?://\S+|www\.\S+', '', text)
    text = re.sub('<.*?>+', '', text)
    text = re.sub('[%s]' % re.escape(string.punctuation), '', text)
    text = re.sub('\n', '', text)
    text = re.sub('\w*\d\w*', '', text)
    return " ".join([word for word in text.split() if word not in stop_words])

# Load the dataset
data_path = r'C:\xampp\htdocs\Interface\Modified_AmazonReview.csv'
data = pd.read_csv(data_path)
data.dropna(inplace=True)
data["Review"] = data["Review"].apply(clean)

# VADER Sentiment Analysis
sia = SentimentIntensityAnalyzer()
data['Scores'] = data['Review'].apply(lambda review: sia.polarity_scores(review))
data['Compound'] = data['Scores'].apply(lambda d: d['compound'])
data['VADER_Sentiment'] = data['Compound'].apply(lambda c: 'Positive' if c > 0.05 else ('Negative' if c < -0.05 else 'Neutral'))

# Text feature extraction for SVM
tfidf_vectorizer = TfidfVectorizer(max_features=1000)
X_tfidf = tfidf_vectorizer.fit_transform(data['Review']).toarray()

# Assuming the presence of a sentiment label, map it for SVM training
y = data['Sentiment'].map({'Positive': 1, 'Negative': -1, 'Neutral': 0}).values

# Splitting dataset for SVM
X_train, X_test, y_train, y_test = train_test_split(X_tfidf, y, test_size=0.2, random_state=42)

# Training SVM
svm_model = SVC(kernel='linear')
svm_model.fit(X_train, y_train)

# Prediction and Evaluation
predictions = svm_model.predict(X_test)
print(classification_report(y_test, predictions))

# Apply SVM for further sentiment analysis
data['SVM_Sentiment'] = svm_model.predict(X_tfidf)
data['SVM_Sentiment_Label'] = data['SVM_Sentiment'].map({1: 'Positive', -1: 'Negative', 0: 'Neutral'})

# Aggregate sentiment information
overall_sentiments = Counter(data['SVM_Sentiment_Label'])

# Convert tuples to strings for grouping by gender
gender_sentiments = data.groupby('Gender')['SVM_Sentiment_Label'].value_counts(normalize=True) * 100
gender_sentiments.index = gender_sentiments.index.map(lambda x: str(x))

# Convert tuples to strings for grouping by age group
age_group_sentiments = data.groupby(pd.cut(data['Age'], bins=[0,18,30,40,50,60,120]))['SVM_Sentiment_Label'].value_counts(normalize=True) * 100
age_group_sentiments.index = age_group_sentiments.index.map(lambda x: str(x))

# Convert tuples to strings for grouping by date
date_sentiments = data.groupby(data['Date'].astype(str))['SVM_Sentiment_Label'].value_counts(normalize=True) * 100
date_sentiments.index = date_sentiments.index.map(lambda x: str(x))

# Package results
results = {
    'Overall': dict(overall_sentiments),
    'ByGender': gender_sentiments.to_dict(),
    'ByAgeGroup': age_group_sentiments.to_dict(),
    'ByDate': date_sentiments.to_dict(),
}

# Save to JSON
output_path = r'C:\xampp\htdocs\Interface\Sentiment_results.json'
with open(output_path, 'w') as f:
    json.dump(results, f, indent=4)

print("Sentiment analysis results and additional metrics saved to JSON file.")
