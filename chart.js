document.addEventListener('DOMContentLoaded', function () {
    const courseSelect = document.getElementById('courseSelect');

    // Function to fetch and populate course options
    function populateCourses() {
        fetch('./api/courses.php')
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
        fetch(`./api/average.php?course=${encodeURIComponent(course)}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.date);
                const scores = data.map(item => item.average_score);

                // Check if chart instance exists and destroy it if it does
                if (window.myChart) {
                    window.myChart.destroy();
                }

                // Create chart
                window.myChart = new Chart(document.getElementById('scoreChart').getContext('2d'), {
                    type: 'line',
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