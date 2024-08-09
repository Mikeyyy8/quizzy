const current = window.location.href;
const allLinks = document.querySelectorAll(".sidebar-links a");

allLinks.forEach((elem) => {
  elem.addEventListener("click", function () {
    const hrefLinkClick = elem.href;

    allLinks.forEach((link) => {
      if (link.href == hrefLinkClick) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
  });
});


document.addEventListener('DOMContentLoaded', function () {
const courseSelect = document.getElementById('filter');

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
populateCourses();

// Add event listener for course selection
courseSelect.addEventListener('change', function () {
    fetchAndRenderChart(this.value);
});
});
