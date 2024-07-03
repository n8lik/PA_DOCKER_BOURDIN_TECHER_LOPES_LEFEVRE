
document.addEventListener('DOMContentLoaded', function () {
    const themeToggleButton = document.getElementById('theme-toggle-button');
    const currentTheme = localStorage.getItem('theme') || 'light';

    document.documentElement.setAttribute('data-theme', currentTheme);

    themeToggleButton.addEventListener('click', function () {
        let theme = document.documentElement.getAttribute('data-theme');
        theme = theme === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
    });
});
