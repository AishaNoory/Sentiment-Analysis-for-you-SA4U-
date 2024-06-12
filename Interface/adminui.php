<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Userin.css">
    <style>
        .graph-container {
            background-color: #f8f9fa; 
            border: 1px solid #dee2e6; 
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #343a40; 
            margin-bottom: 10px;
        }
    
        .container {
            display: flex;
        }
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 200px;
            height: 100vh;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar > a:not(:last-child) {
            margin-bottom: 30px; 
        }
        
        .dashboard {
            margin-left: 200px; 
            flex-grow: 1;
            padding: 20px;
        }
        .sidebar > a:last-child {
            margin-top: auto; 
            margin-bottom: 20px; 
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <a href="users.php" class="icon">
                <img src="user.png" alt="Users Icon" class="icon-img"> Users
            </a>
            <a href="viewpage.php" class="icon">
                <img src="3d-model.png" alt="Model Icon" class="icon-img"> Reviews
            </a>
            <div id="filterOptions" class="icon">
                <h3>Filter Options</h3>
                <input type="checkbox" id="overallCheckbox" checked>
                <label for="overallCheckbox">Overall Sentiment</label><br>
                <input type="checkbox" id="genderCheckbox" checked>
                <label for="genderCheckbox">Sentiment By Gender</label><br>
                <input type="checkbox" id="ageGroupCheckbox" checked>
                <label for="ageGroupCheckbox">Sentiment By Age Group</label><br>
                <input type="checkbox" id="dateCheckbox" checked>
                <label for="dateCheckbox">Sentiment By Date</label><br>
            </div>
            <a href="#" id="downloadAnalytics" class="icon">
                <img src="analytics-icon.png" alt="Analytics Icon" class="icon-img"> Analytics
            </a>
            <div class="spacer"></div>
            <a href="login.html" class="icon">
                <img src="log-in.png" alt="Login/Logout Icon" class="icon-img"> Logout
            </a>
        </div>
        <div class="dashboard">
            <div id="overallGraphContainer" class="graph-container">
                <h2>Overall Sentiment Analysis</h2>
                <canvas id="overallGraphCanvas"></canvas>
            </div>
            <div id="genderGraphContainer" class="graph-container">
                <h2>Sentiment By Gender</h2>
                <canvas id="genderGraphCanvas"></canvas>
            </div>
            <div id="ageGroupGraphContainer" class="graph-container">
                <h2>Sentiment By Age Group</h2>
                <canvas id="ageGroupGraphCanvas"></canvas>
            </div>
            <div id="dateGraphContainer" class="graph-container">
                <h2>Sentiment By Date</h2>
                <canvas id="dateGraphCanvas"></canvas>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var isAdmin = confirm("Are you an admin?");
            if (isAdmin) {
                var userEmail = prompt("Please enter your email to verify you are an admin:");
                if (userEmail && userEmail.endsWith('@sa4u.com')) {
                    alert("Access granted. Welcome, admin.");
                    fetchSentimentData(); // Fetch and visualize data after admin verification
                } else {
                    alert("Access denied. You are not recognized as an admin.");
                    window.location.href = 'login.html';
                }
            } else {
                alert("Access denied. You are not recognized as an admin.");
                window.location.href = 'Homepage.html';
            }
        };

        async function fetchSentimentData() {
            try {
                const response = await fetch('Sentiment_results.json');
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const data = await response.json();
                visualizeData(data);
            } catch (error) {
                console.error('Error fetching sentiment data:', error);
                document.querySelector('.dashboard').innerHTML = '<p class="error-message">Failed to load sentiment data. Please try again later.</p>';
            }
        }

        function visualizeData(data) {
            const showOverall = document.getElementById('overallCheckbox').checked;
            const showGender = document.getElementById('genderCheckbox').checked;
            const showAgeGroup = document.getElementById('ageGroupCheckbox').checked;
            const showDate = document.getElementById('dateCheckbox').checked;

            if (showOverall) createChart('Overall Sentiment', data.Overall, 'overallGraphCanvas');
            if (showGender) createChart('Sentiment By Gender', data.ByGender, 'genderGraphCanvas');
            if (showAgeGroup) createPieChart('Sentiment By Age Group', data.ByAgeGroup, 'ageGroupGraphCanvas');
            if (showDate) createChart('Sentiment By Date', data.ByDate, 'dateGraphCanvas');
        }

        function createChart(title, data, canvasId) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: title,
                    data: Object.values(data),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)', 
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 206, 86, 0.8)', 
                        'rgba(153, 102, 255, 0.8)', 
                        'rgba(255, 159, 64, 0.8)' 
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function createPieChart(title, data, canvasId) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: title,
                    data: Object.values(data),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)', 
                        'rgba(255, 99, 132, 0.8)', 
                        'rgba(75, 192, 192, 0.8)', 
                        'rgba(255, 206, 86, 0.8)', 
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)' 
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right',
                },
            }
        });
    }
        document.getElementById('downloadAnalytics').addEventListener('click', async function(e) {
            e.preventDefault();
            await captureChartsSequentially();
        });

        async function captureChartsSequentially() {
            const doc = new jspdf.jsPDF();
            const chartIds = ['overallGraphCanvas', 'genderGraphCanvas', 'ageGroupGraphCanvas', 'dateGraphCanvas'];
            let yPos = 30; 
            const pdfWidth = doc.internal.pageSize.getWidth();
            const title = "SA4U REPORT";

            // Style the title
            doc.setFontSize(22); 
            doc.setFont('helvetica', 'bold'); 
            const titleWidth = doc.getTextWidth(title);
            const xPos = (pdfWidth - titleWidth) / 2; 
            doc.text(title, xPos, 20); 

            for (const chartId of chartIds) {
                const checkboxId = chartId.replace('GraphCanvas', 'Checkbox');
                if (document.getElementById(checkboxId).checked) {
                    const chartCanvas = document.getElementById(chartId);
                    await new Promise(resolve => setTimeout(resolve, 1000)); 
                    const imgData = chartCanvas.toDataURL('image/png');
                    const img = new Image();
                    img.src = imgData;
                    await new Promise(resolve => img.onload = resolve);

                    const canvasAspectRatio = img.width / img.height;
                    const pdfHeight = (pdfWidth - 40) / canvasAspectRatio; 

                    if (yPos + pdfHeight > doc.internal.pageSize.getHeight() - 20) { 
                        doc.addPage(); // Add a new page if the current one doesn't have enough space
                        yPos = 30; // Reset yPos for the new page
                        doc.setFontSize(22); 
                        doc.setFont('helvetica', 'bold'); 
                        doc.text(title, xPos, 20); 
                    }

                    doc.addImage(imgData, 'PNG', 20, yPos, pdfWidth - 40, pdfHeight); 
                    yPos += pdfHeight + 10; 
                }
            }

            doc.save('AnalyticsReport.pdf');
        }
    </script>
</body>
</html>
