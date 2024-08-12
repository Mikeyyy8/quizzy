document.addEventListener('DOMContentLoaded', function () {
const courseSelect = document.getElementById('filter');

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
    })
      .catch(error => console.error('Error fetching courses:', error));
  }
  
  populateCourses();

  // Add event listener for course selection
  courseSelect.addEventListener('change', function () {
      fetchAndRenderChart(this.value);
  });
});
