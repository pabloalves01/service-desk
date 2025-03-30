const JWT_TTL = import.meta.env.VITE_JWT_TTL || 60;

export const isTokenExpired = (token) => {
  if (!token) return true;
  try {
    const decoded = JSON.parse(atob(token.split(".")[1])); // Decodifica o token
    // exp é o tempo de expiração em segundos desde 1970 (Unix time)
    if (!decoded.exp) {
      return true; // Se o token não tem exp, consideramos expirado.
    }

    const expirationTime = decoded.exp * 1000; // O JWT já armazena `exp` em segundos, multiplicamos por 1000 para ms.
    const currentTime = Date.now();

    return currentTime > expirationTime; // Se a hora atual for maior que a expiração, o token expirou.
  } catch (error) {
    console.error("Erro ao decodificar token:", error);
    return true; // Se der erro ao decodificar, consideramos o token inválido/expirado.
  }
};
