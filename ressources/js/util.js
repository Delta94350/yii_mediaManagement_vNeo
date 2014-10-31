/**
 * @description Check if the login exist
 */
function checkLoginField() {
    var login = $('#inputLogin').val();
    $.post('/index.php/user/checkLogin', {l:login, ajax:true}, function(data) {
        if(data == "t") {
            $('#inputLogin').parent().parent().attr('class', 'form-group has-success has-feedback');
            $('#hasLogin').attr('class', 'glyphicon glyphicon-ok form-control-feedback');
             $('#loginButton').removeAttr('disabled');
        } else {
            $('#inputLogin').parent().parent().attr('class', 'form-group has-error has-feedback');
            $('#hasLogin').attr('class', 'glyphicon glyphicon-remove form-control-feedback');
            $('#loginButton').attr('disabled', 'disabled');
        }
    });
}

function setActiveTab($tab) {
    $('#'+$tab).addClass('active');
}

function updateSeason(idSerie) {
    showModalBlock('body');
    var nv = $('#S'+idSerie).val();
    $('#S'+idSerie).blur();
    $.post('/index.php/serie/updateSeason', {'id':idSerie, 'nv':nv})
        .done(function() {
            hideModalBlock('body');
        })
        .fail(function() {
            hideModalBlock('body');
            $.growlUI('ERREUR', 'Erreur lors de l\'update'); 
    });
}

function updateEpisode(id, manga) {
    showModalBlock('body');
    if(manga==undefined || manga == false) {
        var nv = $('#E'+id).val();
        $('#E'+id).blur();
        $.post('/index.php/serie/updateEpisode', {'id':id, 'nv':nv})
            .done(function() {
                hideModalBlock('body');
            })
            .fail(function() {
                hideModalBlock('body');
                $.growlUI('ERREUR', 'Erreur lors de l\'update'); 
        });
    } else {
        var nv = $('#E'+id).val();
        $('#E'+id).blur();
        $.post('/index.php/manga/updateEpisode', {'id':id, 'nv':nv})
            .done(function() {
                hideModalBlock('body');
            })
            .fail(function() {
                hideModalBlock('body');
                $.growlUI('ERREUR', 'Erreur lors de l\'update'); 
        });
    }
}

function deleteSerie(id, manga) {
    showModalBlock('body');
    if(manga==undefined || manga == false) {
        $.post('/index.php/serie/delete', {'idSerie':id, 'ajax':true})
            .done(function() {
                hideModalBlock('body');
                $('#'+id).html('<td class="text-center" colspan="6"><b>Show deleted !</b></td>');
            })
            .fail(function() {
                hideModalBlock('body');
                $.growlUI('ERROR', 'Error during deleting'); 
        });
    } else {
        $.post('/index.php/manga/delete', {'idManga':id, 'ajax':true})
            .done(function() {
                hideModalBlock('body');
                $('#'+id).html('<td class="text-center" colspan="6"><b>Manga deleted !</b></td>');
            })
            .fail(function() {
                hideModalBlock('body');
                $.growlUI('ERROR', 'Error during deleting'); 
        });
    }
}

function showModalBlock(element, yesNo, yesFunction) {
    if(yesNo==undefined || yesNo == false) {
        $(element).block({ 
            message: '<h3>Processing ...</h1>', 
            css: { border: '1px solid #a00' } 
        }); 
    } else if(yesNo == true) {
        $(element).block({ 
            message: $('#question'), 
            css: { border: '1px solid #a00' } 
        });
        if(yesFunction != undefined && yesFunction != null && yesFunction != "") {
            $('#questionYes').attr('onclick', yesFunction);
        }
    }
}

function showQuickImage(image, type) {
    if(image != null && image != "") {
        $('#quickImage').html('<img style="max-width=30px;" class="quickImage" src="/ressources/upload/images/'+type+'/'+image+'" >');
    }
}

function hideModalBlock(element) {
    $(element).unblock(); 
    return false;
}

function executeFunctionByName(functionName, context , args) {
  var args = [].slice.call(arguments).splice(2);
  var namespaces = functionName.split(".");
  var func = namespaces.pop();
  for(var i = 0; i < namespaces.length; i++) {
    context = context[namespaces[i]];
  }
  return context[func].apply(this, args);
}