// const token = localStorage.getItem("token");
// if (token) {
//     const prevUrl = sessionStorage.getItem("prevUrl");
//     if (prevUrl) {
//         history.replaceState(null, null, prevUrl);
//         window.location.href = prevUrl;
//     } else {
//         history.replaceState(null, null, "/home");
//         window.location.href = "/home";
//     }
// } else {
//     document.getElementById("loginForm").classList.remove("hidden");
// }

// window.addEventListener("popstate", function (event) {
//     const token = localStorage.getItem("token");
//     if (token && window.location.pathname === "/login") {
//         const prevUrl = sessionStorage.getItem("prevUrl");
//         if (prevUrl) {
//             window.location.href = prevUrl;
//         } else {
//             window.location.href = "/home";
//         }
//     }
// });
