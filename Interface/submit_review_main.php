<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SA4U - Submit a Review</title>
    <link rel="stylesheet" href="Userin.css">
    <style>
        body {
            background-color: #f0f0f0; 
            overflow-x: hidden; 
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh; 
            overflow-y: auto; 
        }
        .star-rating {
            display: flex;
            justify-content: center; 
            margin-top: 20px; 
        }

        .star-rating input[type="radio"] {
            display: none; 
        }

        .star-rating label {
            font-size: 24px; 
            color: black;
            cursor: pointer;
        }

        .star-rating label:before {
            content: "\2605"; 
        }

        .star-rating input[type="radio"]:checked~label:before {
            color: #ffd700; 
        }

        button[type="submit"] {
            margin-top: 20px; 
        }

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        /* Adjust background color for form#review-form */
        form#review-form {
            background-color: #f4a0a0; 
            padding: 20px; 
            border-radius: 10px; 
        }

        .faqs {
            background-color: #ffffff; 
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            width: 80%; 
        }

        .faqs h2 {
            text-align: center; 
        }

        .faqs .faq {
            margin-top: 10px;
            color: black;
        }

        .faqs .faq h3 {
            font-size: 18px; 
            color: black;
        }

        .faqs .faq p {
            font-size: 16px; 
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="navbar">
                <a class="HOME" href="Homepage.html">Home</a>
                <a href="submit_review_main.php">Submit Review</a>
                <a href="viewpage.php">View Reviews</a>
                <a href="UserProfile.php">User Profile</a>
                <a href="sign-in.php">Register</a>
                <a href="login.html">Log In</a>
                <a href="adminui.php">Admin</a>
            </div>
            <div>
                <h1>SA4U</h1>
                <p style="font-size: 20px; margin-top: -10px;"><b>Sentiment Analysis for You</b></p>
            </div>
        </header>

        <div class="content">
            <h2>Leave Us a Review</h2>

            <!-- Error message container -->
            <div id="error-message" class="error-message"></div>

            <form id="review-form" action="submit_review.php" method="post">
                <label for="review">Your Review:</label>
                <textarea id="review" name="review" rows="4" placeholder="Write your review here..."></textarea>

                <!-- Star rating section -->
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
                </div>

                <button type="submit">Submit</button>
            </form>
        </div>

        <!-- FAQs Section -->
        <div class="faqs">
            <h2>Frequently Asked Questions</h2>
            <div class="faq">
                <h3>What is SA4U?</h3>
                <p>SA4U stands for Sentiment Analysis for You. It is a platform where users can submit reviews and get their sentiments analyzed.</p>
            </div>
            <div class="faq">
                <h3>How do I submit a review?</h3>
                <p>You can submit a review by filling out the review form above, selecting a star rating, and clicking the "Submit" button.</p>
            </div>
            <div class="faq">
                <h3>What should I include in my review?</h3>
                <p>Your review should include your honest opinion about the service or product you are reviewing. Please be respectful and constructive in your feedback.</p>
            </div>
            <div class="faq">
                <h3>How is my review analyzed?</h3>
                <p>Your review is analyzed using sentiment analysis techniques to determine the overall sentiment (positive, neutral, or negative) of your review.</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("review-form").addEventListener("submit", function (event) {
            var rating = document.querySelector('input[name="rating"]:checked');
            var review = document.getElementById("review").value.trim();
            var errorMessage = document.getElementById("error-message");

            // Reset error message
            errorMessage.textContent = "";

            // Check if rating is selected
            if (!rating) {
                errorMessage.textContent = "Please select a rating.";
                event.preventDefault(); 
                return;
            }

            // Check if review is provided
            if (review === "") {
                errorMessage.textContent = "Please provide a review comment.";
                event.preventDefault(); 
                return;
            }

            // Analyze sentiment of the review comment (simplified)
            var positiveWords = ["good", "great", "excellent"];
            var negativeWords = ["bad", "terrible", "poor"];
            var isPositive = positiveWords.some(word => review.includes(word));
            var isNegative = negativeWords.some(word => review.includes(word));

            // Check if rating matches sentiment of review comment
            if ((rating.value == "5" && !isPositive) || (rating.value == "1" && !isNegative)) {
                // Notify user about the contradictory rating and prevent submission
                alert("Your review comment seems contradictory to the selected rating. Please reconsider your rating before submitting.");
                event.preventDefault(); 
                return;
            }
        });
    </script>
</body>
</html>
