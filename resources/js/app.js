import 'preline'

const THEME_STORAGE_KEY = 'theme'
const systemPrefersDark = () => window.matchMedia('(prefers-color-scheme: dark)').matches

const applyTheme = (theme) => {
    document.documentElement.classList.toggle('dark', theme === 'dark')

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.setAttribute('aria-label', theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode')
        button.setAttribute('aria-pressed', String(theme === 'dark'))
    })
}

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const isDark = !document.documentElement.classList.contains('dark')

        applyTheme(isDark ? 'dark' : 'light')
        localStorage.setItem(THEME_STORAGE_KEY, isDark ? 'dark' : 'light')
    })
})

// Follow OS preference live unless the user picked a theme manually
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
    if (!localStorage.getItem(THEME_STORAGE_KEY)) {
        applyTheme(event.matches ? 'dark' : 'light')
    }
})
