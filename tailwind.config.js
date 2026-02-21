// tailwind.config.js
export default {
    corePlugins: {
        preflight: false, // ← desactiva el reset de Tailwind
    },
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                'primary-dark': 'var(--primary-dark)',
                'secondary-dark': 'var(--secondary-dark)',
                'primary-blue': 'var(--primary-blue)',
                'primary-hover': 'var(--primary-hover)',
                'accent-violet': 'var(--accent-violet)',
                'accent-light': 'var(--accent-light)',
                'text-primary': 'var(--text-primary)',
                'text-secondary': 'var(--text-secondary)',
                'error': 'var(--error-color)',
                'success': 'var(--success-color)',
            },
            borderColor: {
                'nexus': 'var(--border-color)',
            },
            fontFamily: {
                sans: ['Figtree'],
            },
        },
    },
    plugins: [],
};