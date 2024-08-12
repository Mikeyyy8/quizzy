document.addEventListener('DOMContentLoaded', () => {
    const timerElement = document.getElementById('timer');
    const quizForm = document.getElementById('quiz-form');

    // Function to format time as mm:ss
    function formatTime(milliseconds) {
        const totalSeconds = Math.floor(milliseconds / 1000);
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    // Retrieve or set end time
    let quizEndTime = localStorage.getItem('quizEndTime');

    if (!quizEndTime) {
        // Calculate the end time
        const quizDurationMilliseconds = quizDurationMinutes * 60 * 1000;
        quizEndTime = Date.now() + quizDurationMilliseconds;
        localStorage.setItem('quizEndTime', quizEndTime);
    } else {
        quizEndTime = parseInt(quizEndTime, 10);
    }

    // Function to update the timer display
    function updateTimer() {
        const now = Date.now();
        const remainingTime = Math.max(0, quizEndTime - now);
        timerElement.textContent = formatTime(remainingTime);

        if (remainingTime <= 0) {
            clearInterval(timerInterval);
            quizForm.submit();
        }
    }

    // Update the timer every second
    const timerInterval = setInterval(updateTimer, 1000);

    // Initial call to display the time immediately
    updateTimer();
});
