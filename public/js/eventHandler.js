var eventHandler = {

    checkEmailsField: function () {
        var submit = document.getElementById("send_submit");
        if(submit != null) {
            submit.addEventListener("click", function () {
                event.preventDefault();
                pageWidget.checkForNewEmails();
            })
        }
    },

    init: function () {
        this.paginationEvent();
        this.sortingEvent();
        this.checkAllBoxes();
        this.checkSingleBox();
        this.validateJS();
        this.validateAjax();
        pageWidget.markBoxThatAlreadyInCookie();

        this.checkEmailsField();
    },

    paginationEvent: function () {
        var pagination = document.getElementsByClassName("page");
        for(var i =0; i<pagination.length; i++) {
            (function outer(ii) {
                pagination[i].addEventListener("click", function inner() {
                    switch (ii){
                        case 0:
                            if(pageWidget.page > 1) {
                                pageWidget.page -= 1;
                            }
                            break;
                        case pagination.length-1:
                            if(pageWidget.page < pagination.length-2) {
                                pageWidget.page += 1;
                            }
                            break;
                        default:
                            pageWidget.page = parseInt(pagination[ii].innerText);
                    }
                    pageWidget.getPage();
                })
            })(i)
        }
    },

    sortingEvent: function () {
        var sort = document.getElementsByClassName("sort");
        if(sort.length == 2) {
            sort[0].addEventListener("click", function () {
                pageWidget.sort_last = pageWidget.getSorting(pageWidget.sort_last);
                pageWidget.getPage();
            });
            sort[1].addEventListener("click", function () {
                pageWidget.sort_first = pageWidget.getSorting(pageWidget.sort_first);
                pageWidget.getPage();
            });
        }

    },

    checkSingleBox: function () {
        var window_boxes = document.getElementsByClassName("checkboxes");
        if(window_boxes.length >1) {
            for (var i = 0; i < window_boxes.length; i++) {
                window_boxes[i].addEventListener("click", function () {
                    pageWidget.writeCheckedToCookie();
                    pageWidget.deleteNotCheckedFromCookie();
                })
            }
        }
    },

    checkAllBoxes: function () {
        var window_boxes = document.getElementsByClassName("checkboxes"), box_check;
        if(window_boxes.length >1) {
            document.getElementById("check_all").addEventListener("click", function () {
                box_check = document.getElementById("check_all").checked == false ? false: true;
                for (var i = 0, box; box = window_boxes[i]; i++) {
                    box.checked = box_check;
                }
                pageWidget.writeCheckedToCookie();
                pageWidget.deleteNotCheckedFromCookie();
            });
        }
    },

    validateJS: function () {
        var input_field = document.getElementsByTagName("input");
        for(var i=0, input; input = input_field[i]; i++){
            input.addEventListener("keyup", function () {
                pageWidget.validateInput();
            })
        }
    },

    validateAjax: function () {
        var login_form = document.getElementsByClassName("Login")[0],
            register_form = document.getElementsByClassName("Register")[0];

        if (login_form) {
            login_form.addEventListener("click", function () {
                event.preventDefault();
                var fields = pageWidget.getInputFields("login_div");
                var post_params = pageWidget.objectToKeyValueString(fields);
                pageWidget.getAuthorized(post_params, "login");
            })
        }
        if (register_form) {
            register_form.addEventListener("click", function () {
                event.preventDefault();
                var fields = pageWidget.getInputFields("register_div");
                var post_params = pageWidget.objectToKeyValueString(fields);
                pageWidget.getAuthorized(post_params, "register");
            })
        }
    },





};
