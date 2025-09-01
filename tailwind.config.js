/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
 theme: {
        extend: {
            fontFamily: {
                rem: ['REM', 'sans-serif'], 
            },
            colors: {
                dark: '#326672',
                neutral: '#4D9D9E',
                light: '#AED1D3',
            },
        },
    },
  plugins: [],
}
