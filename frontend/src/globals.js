export default {
  urlBase() {
    return import.meta.env.VITE_API_URL;
  },
  logoCorporativa() {
    return import.meta.env.VITE_LOGO_CORPORATIVA;
  },
  funcaoTeste() {
    return 'Teste';
  }
};
