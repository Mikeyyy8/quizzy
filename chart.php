<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Quizzy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="./image/book.ico" type="image/x-icon">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="chart">
<label for="courseSelect">Select Course:</label>
    <select id="courseSelect">
        <!-- Options will be populated dynamically -->
    </select>
    <canvas id="scoreChart" width="400" height="200">
    </canvas>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const courseSelect = document.getElementById('courseSelect');

            // Function to fetch and populate course options
            function populateCourses() {
                fetch('./courses.php')
                    .then(response => response.json())
                    .then(courses => {
                        courses.forEach(course => {
                            const option = document.createElement('option');
                            option.value = course;
                            option.textContent = course;
                            courseSelect.appendChild(option);
                        });

                        // Initialize chart with the default selected course
                        fetchAndRenderChart(courseSelect.value);
                    })
                    .catch(error => console.error('Error fetching courses:', error));
            }

            // Function to fetch and render chart
            function fetchAndRenderChart(course) {
                fetch(`./average.php?course=${encodeURIComponent(course)}`)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.username);
                        const scores = data.map(item => item.average_score);

                        // Check if chart instance exists and destroy it if it does
                        if (window.myChart) {
                            window.myChart.destroy();
                        }

                        // Create chart
                        window.myChart = new Chart(document.getElementById('scoreChart').getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Average Score',
                                    data: scores,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
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
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Populate courses on page load
            populateCourses();

            // Add event listener for course selection
            courseSelect.addEventListener('change', function () {
                fetchAndRenderChart(this.value);
            });
        });
    </script>

</body>
</html>