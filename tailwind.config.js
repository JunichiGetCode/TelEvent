/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
    "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        telu: {
          50: '#FDF2F4',
          100: '#FCE7EB',
          200: '#F9D0D8',
          300: '#F5A9B8',
          400: '#EE748D',
          500: '#E13B63',
          600: '#C60C30', // Official Telkom University Red
          700: '#A70928',
          800: '#8C0A25',
          900: '#750D24',
          950: '#43020F',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        'glow': '0 0 25px -5px rgba(198, 12, 48, 0.3)',
        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
        'premium': '0 20px 40px -15px rgba(0, 0, 0, 0.07)',
      }
    },
  },
  plugins: [],
}
