export const requireAuth = (navigate) => {
  const token = localStorage.getItem("token");
  if (!token) {
    alert("Silakan login terlebih dahulu");
    navigate("/login");
    return false;
  }
  return true;
};
