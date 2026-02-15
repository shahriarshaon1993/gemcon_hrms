
const axios = require("axios");
const defaultOptions = { 
    baseURL: '', 
    headers: {
        "Content-Type": "application/json",
        "Usertimezone": window.timezone,
        "Latitude": '',
        "Longitude": '',
        "App": 'public',
    }
};

let axiosInstance = axios.create(defaultOptions);
axiosInstance.interceptors.request.use(function(config) { 
    return config;
    //let token = localStorageService.getItem("d_token");
    // if (this.$localStorage.get("d_token")) {
    //     let token = this.$localStorage.get("d_token");
    //     let apptype = this.$localStorage.get("user_role");
    //     config.headers.Authorization = token ? `Bearer ${token}` : "";
    //     config.headers.App = apptype ? apptype : "public";
    //     return config;
    // }

});

export default axiosInstance;