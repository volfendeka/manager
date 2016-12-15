var cookieParser ={

    setCookie: function (name, value) {
        document.cookie = name+"="+value+"; path= /";
    },
    getCookie: function (name, cookie_type) {
        var cookie_type = cookie_type || false;
        if(document.cookie.indexOf(name) == -1){
            return false;
        }
        var start_index = document.cookie.indexOf(name) + name.length + 1;
        var this_cookie_string = document.cookie.substring(start_index).split(";")[0];
        if(cookie_type == "array"){
            return this_cookie_string.split(",");
        }
        return this_cookie_string;
    },
    deleteCookie: function (name, value, cookie_type) {
        var value = value || false;
        var cookie_type = cookie_type || false;
        if(value !=false || cookie_type !=false){
            var del_cookie = cookieParser.getCookie(name, cookie_type);
            for (var i=0; i<del_cookie.length; i++){
                if(del_cookie[i] == value){
                    del_cookie.splice(i, 1);
                }
            }
            this.setCookie(name, del_cookie);
        }
    },
    updateCookie: function (name, value, cookie_type) {
        var cookie_to_update = this.getCookie(name, cookie_type), updated_cookie =[], x;
        if(cookieParser.getCookie("id_to_send") == false) {
            this.setCookie(name, value);
        }
        if(cookie_type == "array"){
            x = cookie_to_update.concat(value);
            updated_cookie = x.filter(function (item, pos) { return x.indexOf(item) == pos});
            this.setCookie(name, updated_cookie);
        }
    }
};
