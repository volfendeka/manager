
var pageWidget = {

    page: 1,
    sort_first: "ASC",
    sort_last: "ASC",
    url: 'http://manager.loc/',
    method_name: document.URL.split("/")[4],
    tableJsonAjaxMethod: "jsonAjaxTableData",
    validationJsonAjaxMethod: "authorizationStatus",
    tableId: "",
    columns: [],

    init: function () {

    },
    
    getPage: function () {
        var url = pageWidget.url + "Contacts/"+ pageWidget.tableJsonAjaxMethod +"/"+ pageWidget.sort_last +"/"+ pageWidget.sort_first +"/"+ pageWidget.page +"/";
        if(document.getElementById("index_table")) {
            pageWidget.tableId = "index_table";
            pageWidget.columns = ["number","last_name", "first_name", "email", "cell_phone", "actions"];
        }else if(document.getElementById("check_table")) {
            pageWidget.tableId = "check_table";
            pageWidget.columns = ["number", "check_box", "last_name", "first_name", "email"];
        }

        ajaxLoader.loadDoc(url, pageWidget.sortingPagingJsonData, "GET");
    },

    getAuthorized: function (post_params, action) {
        post_params += "&action="+action;
        var url = pageWidget.url + "Users/"+ pageWidget.validationJsonAjaxMethod +"/";
        ajaxLoader.loadDoc(url, pageWidget.getServerValidationStatus, "POST", post_params);
    },


    getSorting: function (sorting_param) {
        if(sorting_param == "ASC"){
            sorting_param = "DESC";
        }else{
            sorting_param = "ASC";
        }
        return sorting_param;
    },

    writeCheckedToCookie: function () {
        var checked = [], boxes = document.getElementsByTagName("input");
        for(var i=0, box; box = boxes[i]; i++){
            if(box.getAttribute("class")=="checkboxes" && box.checked){
                checked.push(box.getAttribute("value"));
            };
        }
        if(cookieParser.getCookie("id_to_send") == false) {
            cookieParser.setCookie("id_to_send", checked);
        }
        cookieParser.updateCookie("id_to_send", checked, "array");
        console.log(cookieParser.getCookie("id_to_send", "array")); 
    },

    deleteNotCheckedFromCookie : function () {
        var boxes = document.getElementsByClassName("checkboxes"),
            cookie_value = cookieParser.getCookie("id_to_send", "array");
        for(var i=0, box; box = boxes[i]; i++){
            for(var j=0, cookie; cookie = cookie_value[j]; j++){
                if(box.checked == false && box.value == cookie){
                    cookieParser.deleteCookie("id_to_send", cookie, "array");
                    console.log(box+" and "+ cookie);
                }
            }
        }
    },

    getWindowCheckBoxes: function (class_name) {
        var window_boxes = [], boxes = document.getElementsByTagName("input");
        for(var i=0; i<boxes.length; i++){
            if(boxes[i].getAttribute("class")==class_name){
                window_boxes.push(boxes[i].getAttribute("value"));
            }
        }
        return window_boxes;
    },

    markBoxThatAlreadyInCookie: function () {
        var checked_from_cookie = cookieParser.getCookie("id_to_send", "array"),
            window_boxes =pageWidget.getWindowCheckBoxes("checkboxes"),
            counter = 0;
        if(window_boxes.length >1) {
            for (var i = 0; i < checked_from_cookie.length; i++) {
                for (var j = 0; j < window_boxes.length; j++) {
                    if (checked_from_cookie[i] == window_boxes[j]) {
                        document.getElementsByClassName("checkboxes")[j].checked = true;
                        counter++;
                    }
                }
            }
            if (counter == window_boxes.length && window_boxes.length != 0) {
                document.getElementById("check_all").checked = true;
            } else {
                document.getElementById("check_all").checked = false;
            }
        }
    },

    validationRules: {
        login:  new RegExp("^[a-zA-Z ]*$"),
        password: new RegExp("^[a-zA-Z]|[0-9]$"),
        email: new RegExp("^\\w+@[a-zA-Z_]+?\\.[a-zA-Z]{2,3}$"),
        home_phone:  new RegExp("^(\\d[\\s-]?)?[\\(\\[\\s-]{0,2}?\\d{3}[\\)\\]\\s-]{0,2}?\\d{3}[\\s-]?\\d{4}$"),
        repeat_password: new RegExp("^[a-zA-Z]|[0-9]$"),
        first_name: new RegExp("^[a-zA-Z ]*$"),
        last_name: new RegExp("^[a-zA-Z ]*$"),
        work_phone:  new RegExp("^(\\d[\\s-]?)?[\\(\\[\\s-]{0,2}?\\d{3}[\\)\\]\\s-]{0,2}?\\d{3}[\\s-]?\\d{4}$"),
        cell_phone:  new RegExp("^(\\d[\\s-]?)?[\\(\\[\\s-]{0,2}?\\d{3}[\\)\\]\\s-]{0,2}?\\d{3}[\\s-]?\\d{4}$"),
        best_phone: new RegExp("^(\\d[\\s-]?)?[\\(\\[\\s-]{0,2}?\\d{3}[\\)\\]\\s-]{0,2}?\\d{3}[\\s-]?\\d{4}$")
    },

    validateInput: function () {
        var fields_to_validate = document.getElementsByTagName("input");
        for(var i=0, field; field = fields_to_validate[i]; i++){
            Object.getOwnPropertyNames(pageWidget.validationRules).forEach(function (key) {
                if(field.getAttribute("name") == key){
                    var regex = pageWidget.validationRules[key];
                    if(field.value !== "") {
                        if (regex.test(field.value)) {
                            field.nextElementSibling.innerHTML = "";
                        } else {
                            field.nextElementSibling.innerHTML = "invalid " + key + " format";
                        }
                    }else{
                        field.nextElementSibling.innerHTML = "";
                    }
                }
            })
        }
    },

    objectToKeyValueString: function (key_value) {
        var key_value_string = "";
        for(var key in key_value){
            key_value_string += key+"="+key_value[key]+"&";
        }
        return key_value_string.slice(0, -1);
    },

    getInputFields: function (classname) {
        var div_block = document.getElementsByClassName(classname),
            fields = "",
            key_value = {};

        for(var i=0; i < div_block[0].childNodes.length; i++)
            if(div_block[0].childNodes[i].nodeName == 'INPUT'){
                fields = div_block[0].childNodes[i];
                key_value[fields.getAttribute("name")]= fields.value;
            }
        return key_value;
    },

    checkForNewEmails: function () {
        var text_field = document.getElementById("send_field").value.split(",");
        //ajaxLoader.loadDoc(pageWidget.url + "Contacts/jsonAjax/ASC/ASC/1/", pageWidget.transferJsonData, "GET");
        console.log(text_field);
    },
    
    sortingPagingJsonData: function (executeXhttp) {
        var response = JSON.parse(executeXhttp.responseText),
            table = document.getElementById(pageWidget.tableId).children[0],
            data_object_length = response.contacts_data.length,
            table_row = [],
            data = {},
            number = 0;
        console.log(response);
        for(var i=0; i < table.children.length-2; i++ ){
            table_row = table.children[i+1];
            data = (i<=data_object_length) ? response.contacts_data[i] : {};
            number ++;
            pageWidget.getTableData(table_row, data, number, data_object_length);
        }
        pageWidget.markBoxThatAlreadyInCookie();
        eventHandler.checkSingleBox();
    },

    getTableData: function (table_row, data, number, data_object_length) {
        var actions = ["edit", "view", "delete"],
            table_data, column_name = [];

        for(var k=0; k < table_row.children.length; k++){
                table_data = table_row.children[k].children[0],
                column_name = pageWidget.columns[k];
            if(number > data_object_length){
                table_data.innerHTML = " ";
            }else {
                Object.getOwnPropertyNames(data).forEach(function (key) {
                    switch (column_name){
                        case "number":
                            table_data.innerHTML = number + ".";
                            break;
                        case key:
                            table_data.innerHTML = data[key];
                            break;
                        case "actions":
                            var action_link =[];
                            for(var a=0; a < actions.length; a++){
                                action_link[a] = pageWidget.url + "Contacts/"+actions[a]+"Contact/"+data['id']+"/";
                            }
                            table_data.innerHTML = '<a href="'+action_link[0]+'"><div class="edit_button">edit</div></a>'+
                                                   '<a href="'+action_link[1]+'"><div class="view_button">view</div></a>'+
                        '<div class="delete_button"><a href="'+action_link[2]+'">&#10005</a></div>';
                            break;
                        case "check_box":
                            table_data.innerHTML = '<input type="checkbox" class="checkboxes" value="'+ data["id"]+'">';
                            break;
                    }
                });
            }
        };
    },

    getServerValidationStatus: function (executeXhttp) {
        var response = JSON.parse(executeXhttp.responseText),
            fields_to_validate = document.getElementsByTagName("input");
        console.log(response);
        if(!response){
            var url = pageWidget.url + "Contacts/showContacts/"+ pageWidget.sort_last +"/"+ pageWidget.sort_first +"/"+ pageWidget.page +"/";
            ajaxLoader.loadDoc(url, ajaxLoader.executeDoc, "GET");
        }else {
            for (var i = 0, field; field = fields_to_validate[i]; i++) {
                Object.getOwnPropertyNames(response).forEach(function (key) {
                    if (field.getAttribute("name") == key) {
                        field.nextElementSibling.innerHTML = response[key];
                    }
                })
            }
        }
    },
    



};



var ajaxLoader = {

    loadDoc: function (url, callBack, method, params) {
        var params = params || false;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                return callBack(this);
            }
        };
        xhttp.open(method, url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        if(method == "POST"){
            xhttp.send(params);
        }else{
            xhttp.send();
        }
    },

    executeDoc: function (executeXhttp) {
        document.getElementById("body").innerHTML = executeXhttp.responseText;
        eventHandler.init();
        }
};




