
function addAnItem(source, tag) {
    // si il n'y a pas de tag définie mettre __name__ par default
    tag = tag || "__name__";
    var regpat = new RegExp(tag, "gi")
    //    alert($(source).prevAll("div").first().prop("id"));
    // this function will add an item to a collection from a data-prototype as created by symfony 2's form with option allow_add and data-prototype set to true
    // It will use the length of the child in the data-prototype div, or, the length of all the childs of all the div with the data-join-class class.
    // This is to allow use to create many forms for a single type of relationship in a table inheritance situtation
    // -------------
    // #TODO : will have to redo the numbering, take into considaration that delete will remove some numbers in the so we can end up with 2 ..._2 if ..._1 was deleted <--- FIX PLZ
    tag = tag || "__name__";
    var regpat = new RegExp(tag, "gi")
    newnode = document.createElement("div");

    next_id = $("div").filter(function() {
        return this.id.match('^' + source + '[_][0-9]*$');
    }).length;
    newnode.innerHTML = $("#" + source).attr('data-prototype').replace(regpat, next_id);
    //     mets le selected sur l'option selon l'index du select pour mettre l' option en anglais plus nescessaire normalement à été corrigé dans translation.html.twig
//    $(newnode.firstChild).find("select[id$='trans_lang']").each(function(index, element) {
//        $(element).find("option:eq(" + index + ")").attr("selected", "selected");
//    });

    var ajouter = document.getElementById(source).appendChild(newnode.firstChild);

    // puts the ckeditor where it is needed, really it reloads for all ckeditor class under (ajouter)
    addCkEditorTo(ajouter);

    // clicker les nav langue pour afficher les bonne traductions, Sinon par défaut lors de l'ajout le nouveau item apparait en français'
    $(".nav").filter(".lang").find(".active").click();
}

function addHtmlContent(source, tag, cible) {
    // si il n'y a pas de tag définie mettre __name__ par default
    tag = tag || "__name__";
    var regpat = new RegExp(tag, "gi")
    newnode = document.createElement("div");

    next_id = $("div").filter(function() {
        return this.id.match('^' + source + '[_][0-9]*$');
    }).length;
    newnode.innerHTML = $("#" + source).attr('data-prototype').replace(regpat, next_id);
    //     mets le selected sur l'option selon l'index du select pour mettre l' option en anglais plus nescessaire normalement à été corrigé dans translation.html.twig

    var ajouter = document.getElementById(cible).appendChild(newnode.firstChild);
    $(ajouter).find("input[id$='area']").attr("value", cible);

    // puts the ckeditor where it is needed, really it reloads for all ckeditor class under (ajouter)
    addCkEditorTo(ajouter);

    // clicker les nav langue pour afficher les bonne traductions, Sinon par défaut lors de l'ajout le nouveau item apparait en français'
    $(".nav").filter(".lang").find(".active").click();
}
/*
 function addAnEntreprise(source){
 //    alert($(source).prevAll("div").first().prop("id"));
 // this function will add an item to a collection from a data-prototype as created by symfony 2's form with option allow_add and data-prototype set to true
 // It will use the length of the child in the data-prototype div, or, the length of all the childs of all the div with the data-join-class class.
 // This is to allow use to create many forms for a single type of relationship in a table inheritance situtation
 // -------------
 // #TODO : will have to redo the numbering, take into considaration that delete will remove some numbers in the so we can end up with 2 ..._2 if ..._1 was deleted <--- FIX PLZ
 newnode = document.createElement("div");
 //    next_id = $("#"+source).attr('data-join-class')?$("."+$("#"+source).attr('data-join-class')).children().length:$("#"+source).children().length;
 next_id = ($("#"+source).children("div:last").children().children().attr("id") == undefined)? 0 : parseInt($("#"+source).children("div:last").children().children().attr("id").match(/\d+\.?\d*$/g)) + 1;
 newnode.innerHTML =$("#"+source).attr('data-prototype').replace(/__name__/gi, next_id);
 //     mets le selected sur l'option selon l'index du select pour mettre l' option en anglais
 $(newnode.firstChild).find("select").each(function(index , element){
 $(element).find("option:eq("+index+")").attr("selected", "selected");
 });
 //    hides all the translations but the first one
 $(newnode.firstChild).find(".nav div.inside").children().each(function(index , element){
 if(index!==0)$(element).addClass("hidden");
 }); 
 document.getElementById(source).appendChild(newnode.firstChild);
 }
 */
function showFormElementClass(tab) {
//    alert($(tab).attr("data-formname"));
//    $("div[id^=" + $(tab).attr("data-formname")+"]").children("div.trans").hide();
//    $("div[id^=" + $(tab).attr("data-formname") + "]").each(function() {
//        alert($(this).html());
//    });
    $("div[id^=" + $(tab).attr("data-formname") + "]").filter("[id*='translations_']").filter(".trans_div").hide();
    $("div[id^=" + $(tab).attr("data-formname") + "]").filter("[id$='translations_" + $(tab).attr("data-langindex") + "']").filter(".trans_div").show();
    $(tab).siblings("li").removeClass("active");
    //$("." + $(tab).attr("rel")).show();
    $(tab).addClass("active");
}

//function showFormElement(tab) {
////    $("#" + $(tab).attr("rel")).siblings().hide();
////    $(tab).siblings("li").removeClass("active");
//    $(".trans").hide();
//    $("." + $(tab).attr("rel")).show();
//    $("#" + $(tab).attr("rel")).show();
////    $(tab).addClass("active");
//}

function ajaxLogin(form, data) {

    var login_infos = '_password=' + form.password.value + '&_username=' + form.username.value + '&_csrf_token=' + form._token.value;
    $.ajax({
        url: form.action,
        cache: false,
        type: "post",
        data: login_infos,
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "NotLoggedIn") {
                $("#login_div").html(obj.render);
            } else if (obj.message == "IsLoggedIn") {
                $("#user-greeter").hide();
                $("#user-greeter").html(obj.render).fadeIn("slow");

                $(form).parentsUntil('.container').fadeOut("slow");
                $("a.signin").remove();
                $("#monespace").removeAttr('onclick');
            }
        }
    });
    return false;
}

function ajaxRegister(form, data) {
    var register_infos = $(form).serialize();
    $.ajax({
        url: form.action,
        cache: false,
        type: "post",
        data: register_infos,
        datatype: "json",
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "NotRegistered") {
                $("#register_div").html(obj.render);
            } else if (obj.message == "IsRegistered") {
                $("#signin_menu").html(obj.render);
                //                $("#user-greeter").hide();
                //                $("#user-greeter").html(obj.render).fadeIn("slow");

                //                $(form).parentsUntil('.container').fadeOut("slow");
                //                $("a.signin").remove();
                //                $("#monespace").removeAttr('onclick');
            }
        }
    });
    return false;
}
function ajaxPostRequest(form, data) {
    var reset_infos = $(form).serialize();
    $.ajax({
        url: form.action,
        cache: false,
        type: "post",
        data: reset_infos,
        datatype: "json",
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "emailNotFound") {
                $("#inside-reset-box").html(obj.render);
            } else if (obj.message == "resetSent") {
                $("#inside-reset-box").html(obj.render);
            }
        }
    });
    return false;
}



function getHiddenDateElement(picker_date) {
    return $("#" + $(picker_date).attr("id").replace("_picker", ""))
}
function getDateAsArray(date, date_format, separator) {
    values = date.split(separator);
    formats = date_format.split(separator);
    date_array = [];
    for (key in formats) {
        date_array[formats[key]] = values[key];
    }
    return date_array;
}

function setCalendar() {
    $("input.datepicker").each(function() {

        /**
         * Récupère la valeur du champs date masqué.
         * Si il y aune valeur, expl
         */
        if (date_value = getHiddenDateElement(this).val()) {
            format = $(this).attr('data-date-format').split("/");
            date_as_array = getDateAsArray(date_value, "yy-mm-dd", "-");
            $(this).attr("value", date_as_array[format[0]] + "/" + date_as_array[format[1]] + "/" + date_as_array[format[2]]);
        }

        if (!$(this).hasClass("disable-datepicker")) {
            $(this).datepicker({
                showOn: "button",
                buttonImage: "/images/calendar.png",
                dateFormat: $(this).attr('data-date-format'),
                buttonImageOnly: true,
                onSelect: function(dateText, inst) {
                    date_as_array = getDateAsArray($(this).val(), $(this).attr('data-date-format'), "/");
                    $(getHiddenDateElement(this)).attr("value", date_as_array["yy"] + "-" + date_as_array["mm"] + "-" + date_as_array["dd"]);
                }
            });
        }
    });
}

function clearDatePicker(id) {
    $('#' + id).val("");
    $('#' + id + "_picker").val("");
}

function MenuOpen(target) {
    $(target).children("ul").slideDown();
    $(target).children("ul").mouseleave(function() {
        $(this).slideUp(); //slides back up 
        $(this).off("mouseleave"); // then remove the event
    });
    $(target).mouseleave(function() {
        $(this).children("ul").slideUp(); //slides back up 
        $(this).off("mouseleave"); // then remove the event
    });
}

function remove_item(button) {
    if (confirm("Cette information va être définitivement supprimée lors de la sauvegarde.")) {
        $(button).parent().parent().remove();
    }
    else {
        return false;
    }
}

function toggleRH(target) {
    if ($(target).find("input[type=radio]:checked").val() == 1) {
        $(target).siblings(".rh").show("slow");
    } else {
        $(target).siblings(".rh").hide("slow");
    }
    ;
}

function toggleAnItem(source, tag, courant) {
    //    trouve si il exist déjà un element
    if ($("#" + source).children("div:last").attr("id") == undefined) {
        addAnItem(source, tag);
        $(courant).html("Adresse identique")
    } else {
        $("#" + source).children("div:last").remove();
        $(courant).html("Adresse différente")
    }
}

function showStates($id, $index) {
    $("#" + $id).find("option").hide();
    $("#" + $id).find("option." + $id + "_" + $index).show();
}
function evalItemAccordeon(item) {
    $(item).parent().siblings().find(".inside").hide("slow");
    $(item).parent().find(".inside").show("slow");
}
function showNewItem(item) {
    $("#" + item).children().find(".inside").hide("slow");
    $("#" + item).children().last().find(".inside").show("slow");
    //create the first point in ajouter jeu de points
    $("#" + item).children().last().find(".inside").find('label.btn').click();
}

function ajaxDossierUpdate(link, method, data) {
    //    il faut utiliser l'objet javascript FormData, car une simple serialization n'upload pas les fichiers
    if (data) {
        var form_data = new FormData($(data).get(0));
    }

    $.ajax({
        url: link.href,
        cache: false,
        type: method,
        data: form_data,
        datatype: "json",
        cache: false,
                contentType: false,
        processData: false,
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "success") {
                $("#dossierUpdateBox" + obj.id).html(obj.render);
                $("#dossierUpdateBox" + obj.id).dialog({
                    width: "65%",
                    modal: true
                });
            }
        }
    });
}

function ajaxDossierUpdateStatus(link, method, data) {
    //    il faut utiliser l'objet javascript FormData, car une simple serialization n'upload pas les fichiers
    if (data) {
        var form_data = new FormData($(data).get(0));
    }

    $.ajax({
        url: link.href,
        cache: false,
        type: method,
        data: form_data,
        datatype: "json",
        cache: false,
                contentType: false,
        processData: false,
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "success") {
                $("#dossierUpdateStatusBox").html(obj.render);
                $("#dossierUpdateStatusBox").dialog({
                    width: "60%",
                    modal: true
                });

                if (obj.reload) {
                    setTimeout("location.reload(true);", 3000);
                }
            }
        }
    });
}

function ajaxDossierChangeServiceState(link, method, element, service) {

    if (service === "reference") {
        link = link + "?&nb=" + parseFloat($("#website_bundle_sitebundle_dossiertype_service_" + service).children().length + $(".service_reference_child").length);
    } else {
        link = link + "?&nb=" + $("#website_bundle_sitebundle_dossiertype_service_" + service).children().length;
    }

    $.ajax({
        url: link,
        cache: false,
        type: method,
        datatype: "json",
        cache: false,
                contentType: false,
        processData: false,
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);

            if (obj.message == "success") {
                $(element).attr('class', 'btn ' + obj.state);
            } else if (obj.message == "error") {
                $(element).parent().parent().parent().find(".alert-error-service").html(obj.flash).fadeIn();
            }
        }
    });
    cancelBubble(event);
}

function ajaxChangeVisibilityDossier(link, method, element) {

    $.ajax({
        url: link,
        cache: false,
        type: method,
        datatype: "json",
        cache: false,
                contentType: false,
        processData: false,
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);

            if (obj.message == "success") {
                //   $(element).attr('class', 'btn '+obj.visibility);
                $(element).find("img").attr('src', '/images/' + obj.visibility + '.png');
            }
        }
    });
    cancelBubble(event);
}

function ajaxSearch(link, data) {
    if (data) {
        var form_data = $(data).serialize();
        // alert(data.action);
        // alert(link);
        //method = data.method;
    } else {
        // method = "GET"
    }
    $.ajax({
        url: link.href,
        cache: false,
        type: "get",
        data: form_data,
        datatype: "json",
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "success") {
                $("#searchBox").html(obj.render);
                $("#searchBox").dialog({
                    width: "80%",
                    modal: true
                });
            }
        }
    });
    return false;
}

function copycase(link) {
    //for( key in data)
    var data = {
        'lastname': $('#website_bundle_sitebundle_dossiertype_candidat_lastname').val(),
        'firstname': $('#website_bundle_sitebundle_dossiertype_candidat_firstname').val()
    };
    $.ajax({
        url: link.href,
        cache: false,
        type: "get",
        data: data,
        datatype: "json",
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "success") {
                $("#searchBox").html(obj.render);
                $("#searchBox").dialog({
                    width: "80%",
                    modal: true
                });
            }
        }
    });
    return false;
}


function ajaxToggleStatus(data) {
    var form_data = $(data).serialize();
    $.ajax({
        url: data.action,
        cache: false,
        type: data.method,
        data: form_data,
        datatype: "json",
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "success") {
                $("#searchBox").html(obj.render);
                $("#searchBox").dialog({
                    width: "80%",
                    modal: true
                });
            }
        }
    });
    return false;
}

function ajaxSelectConseiller(data, element) {
    var form_data = $(data).serialize();
    data.action = $(data).prop("action");
    $.ajax({
        url: data.action,
        cache: false,
        type: 'POST',
        data: form_data,
        datatype: "json",
        complete: function(data, status) {
            var obj = $.parseJSON(data.responseText);
            if (obj.message == "success") {
                $(element).parent().parent('.conseiller').html(obj.render);

                if (obj.reload)
                    $('#searchBox').dialog('option', 'close', function() {
                        parent.location.reload(true);
                    });
            }
        }
    });
    return false;
}

function collapse(target) {
    $(target).siblings().toggle();
    $(target).closest("table").find("tbody").toggle();
}

function getRequerant(data) {
    if ($(data).val()) {
        console.log($(data).val());
        console.log($(data).parent().attr("data-url"));
        var form_action = $(data).parent().attr("data-url");
        var form_data = $(data).serialize();
        console.log($(data).serialize());
        $.ajax({
            url: form_action,
            cache: false,
            type: "POST",
            data: form_data,
            datatype: "json",
            complete: function(data, status) {
                var obj = $.parseJSON(data.responseText);
                if (obj.message == "success") {
                    $("#requerant_box").html(obj.render);
                }
            }
        });
    } else {
        $("#requerant_box").html("");
    }
    return false;
}

function changeFormatRapport() {

    //    console.log($(select).find("input[type=radio]:checked").val());
    //    console.log($(select).val());
    //   console.log("-->"+default_rapport);

    if (!$(".report").children().children("div").size() || confirm("Êtes-vous sûre de vouloir éffacer " + $(".report").children().children("div").size() + " rapport(s).")) {
        // console.log($(".report").children().children("div").size());
        $(".report").children().children("div").remove();
        showRapportSelect();
    } else {
        $("#website_bundle_sitebundle_dossiertype_format_rapport").find("input[value=" + default_rapport + "]").prop("checked", "checked");
        return false;
    }
    return true;
}

function showRapportSelect() {
    switch ($("#website_bundle_sitebundle_dossiertype_format_rapport").find("input[type=radio]:checked").val()) {
        case "1" :
            target = $('.rep_text');
            break;
        case "2":
            target = $('.rep_point');
            break;
        case "3":
            target = $('.rep_synth');
            break;
    }
    $(".report").hide();
    $(target).show();
}

function changeServicesDemande(select) {
    var wrapper = $(select).closest('span[rel$="wrapper"]')

    if (wrapper.find("input[type=checkbox]:checked").length) {
        console.log("enable: " + wrapper.attr("rel"));
        $("#" + wrapper.attr("rel")).show();
        //enableAllIn($("#"+wrapper.attr("rel")));
    } else {
        if (!disableService(wrapper)) {
            //            remet le check si on a refuser d'éffacer les données existante'
            $(select).attr("checked", "checked");
        }
    }
}


// en fait le target est le wrapper des checkbox qui on le nom du div du service dans son attribut rel
function disableService(target) {
    //    pour disable le service on confirme avec l'usager si il y a des entrées, on enleve les instances de ckeditor, puis on enleve tout les entrées et on ferme le div du service.
    var serviceDiv = $("#" + $(target).attr("rel").substring(0, $(target).attr("rel").indexOf("_wrapper", 0))).children().first();
    var nombreElements = serviceDiv.children().length;
    if (nombreElements) {
        // ici il faudra trouver ou mettre le message.
        if (confirm("Il y a déjà des éléments(" + nombreElements + ") dans ce rapport. Si vous continuez ils seront éffacés")) {
            removeCkEditorFrom(serviceDiv);
            serviceDiv.children().remove();
        } else {
            //            retourne faux pour que l'on remette la coche sur le checkbox'
            return false;
        }
    }
    $("#" + $(target).attr("rel")).hide("slow");
    return true;
}

function addCkEditorTo(target) {
    $(target).find("textarea.ckeditor").each(function() {
        prepareEditor(this);
    });
}

function prepareEditor(editor) {
//    toolbar = ['NumberedList', 'Table'];
//    if ($(editor).hasClass("ck-criminal")) {
//        toolbar.push('TableCriminal');
//    } else if ($(editor).hasClass("ck-credit")) {
//        toolbar.push('TableCredit');
//        toolbar.push('TableRecouvrement');
//    } else if ($(editor).hasClass("ck-scolarite")) {
//        toolbar.push('TableScolarite');
//    }

    //        lang = $("#" + $(this).attr("id").replace(/text$/, "trans_lang") + " option:selected").html();
    CKEDITOR.replace(editor, {
        toolbar: [toolbar]
    });
}


function removeCkEditorFrom(target) {
    $(target).find("textarea.ckeditor").each(function() {
        // doit remove les instances de ckeditor par id
        CKEDITOR.remove(CKEDITOR.instances[$(this).attr("id")]);
    });
}

function cancelBubble(e) {
    var evt = e ? e : window.event;
    if (evt.stopPropagation)
        evt.stopPropagation();
    if (evt.cancelBubble != null)
        evt.cancelBubble = true;
}

//function ajaxSearchEnterKey(element) {
//    if (isEnterPress()) {
//        $("#search-button").click();
//        cancelKeypressEvent();
//    }
//}

//function cancelKeypressEvent() {
//    window.event.cancelBubble = true;
//    window.event.returnValue = false;
//
//    if (window.event.stopPropagation) {
//        window.event.stopPropagation();
//        window.event.preventDefault();
//    }
//}

//function isEnterPress() { // the arguments here are the event (needed to detect which key is pressed), and the name of the resulting function to run if Enter has been pressed.
//
//    var keynum; // establish variable to contain the value of the key that was pressed
//
//    // now, set that variable equal to the key that was pressed
//
//    if (window.event) // ID
//    {
//        keynum = window.event.keyCode;
//    }
//    else if (e.which) // other browsers
//    {
//        keynum = window.event.which;
//    }
//
//    if (keynum == 13) {  // if the key that was pressed was Enter (ascii code 13)
//        return true; // run the resulting function name that was specified as an argument
//    } else {
//        return false;
//    }
//}

//function uncomplete(target) {
//    if ($(target + ".done").length) {
//        confirm('Cette action va enlever le complete de ce service');
//    }
//    $(target + ".done").triggerHandler("click");
//}
function remove_item_by_id(id) {
    if (confirm("Cette information va être définitivement supprimée lors de la sauvegarde.")) {
        $("#" + id).find("div.ckeditor").find("textarea").each(
                function() {
                    CKEDITOR.instances[$(this).attr("id")].destroy();
                }
        );
        $("#" + id).remove();
    }
    else {
        return false;
    }
}

$(document).ready(setCalendar());
$(document).ready(function() {
    $('textarea.ckeditor').each(function() {
        prepareEditor(this);
    });
})


function ranking(arrow, line_element) {
    old_rank = $(arrow).closest(line_element).find("input[name$='rank']").val();

    if ($(arrow).hasClass('up')) {
        new_rank = $(arrow).closest(line_element).prev().find("input[name$='rank']").val();
        $(arrow).closest(line_element).insertBefore($(arrow).closest(line_element).prev()).next().find("input[name$='rank']").val(old_rank);
    } else {
        new_rank = $(arrow).closest(line_element).next().find("input[name$='rank']").val();
        $(arrow).closest(line_element).insertAfter($(arrow).closest('tr').next()).prev().find("input[name$='rank']").val(old_rank);
    }

    $(arrow).closest(line_element).find("input[name$='rank']").val(new_rank);
    $(arrow).closest(line_element).find("button").removeClass("hidden");
}

/**
 * 
 * @param {type} element
 * @param {type} cible
 * @returns {undefined}
 * 
 * La cible peut être un input ou un textarea dans ce cas la ligne pourra être:
 * 
 * $(element).closest("form").find("texterea[id$='_title']").val(CKEDITOR.instances["title"].getData());
 * $(element).closest("form").find("input[id$='_title']").val(CKEDITOR.instances["title"].getData());
 */
function updateContent(element, cible) {
    $(element).closest("form").find(cible + "[id$='" + $(element).attr("id").replace("_inline", "") + "']").val($(element).html());
}

$(function() {
    $(".sortable").sortable({
        revert: true,
        update: function(event, ui) {
            ui.item.closest(".sortable").children().each(
                    function(key, value) {
                        $(this).find("input[name$='rank']").val(parseInt(key + 1));
                    }
            );
            ui.item.find("button").removeClass("hidden");
        }
    });
})

