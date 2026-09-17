function call_user_func_array(cb, parameters) {  
    // Call a user function which is the first parameter with the arguments contained in array    
    var func;

    if (typeof cb == 'string') {
      if (typeof this[cb] == 'function') {
        func = this[cb];
      } else {
        func = (new Function(null, 'return ' + cb))();  
      }
    } else if (cb instanceof Array) {
      func = eval(cb[0]+"['"+cb[1]+"']");  
    }
      
    if (typeof func != 'function') {  
        throw new Exception(func + ' is not a valid function');  
    }  
  
    return func.apply(null, parameters);  
}

function platform_alert(alert_object) {
  return false;

  $("#platform_alert_header").html(alert_object.title);
  $("#platform_alert_body").html(alert_object.msg);

  var btn_group = '';
  for (var i = 0; i < alert_object.buttons.length; i++) {
    var button = '<button class="'+alert_object.buttons[i].class+'" onclick="'+alert_object.buttons[i].function+'('+alert_object.buttons[i].arguments+')">'+alert_object.buttons[i].text+'</button>';
    btn_group += button;
  }

  if (btn_group != '') {
    $("#platform_alert_footer").html(btn_group);
  }

  $("#platform_alert_box").show();
  $("#platform_alert_wrapper").show();
}

function platform_alert_close() {
  $("#platform_alert_wrapper").hide();
  $("#platform_alert_box").hide();  
}


function platform_prompt(prompt_object) {
  $("#platform_prompt_header").html(prompt_object.title);

  var msg = prompt_object.msg;

  for (var i = 0; i < prompt_object.inputs.length; i++) {
    msg += '<div class="platform_input_group"><div class="label">'+prompt_object.inputs[i].label+'</div><input type="'+prompt_object.inputs[i].type+'" class="'+prompt_object.inputs[i].class+'" value="'+prompt_object.inputs[i].value+'"></div>';
  }

  $("#platform_prompt_body").html(msg);

  var btn_group = '';
  for (var i = 0; i < prompt_object.buttons.length; i++) {
    var button = '<button class="'+prompt_object.buttons[i].class+'" onclick="'+prompt_object.buttons[i].function+'('+prompt_object.buttons[i].arguments+')">'+prompt_object.buttons[i].text+'</button>';
    btn_group += button;
  }

  if (btn_group != '') {
    $("#platform_prompt_footer").html(btn_group);
  }

  $("#platform_prompt_box").show();
  $("#platform_prompt_wrapper").show();
}

function platform_prompt_close() {
  $("#platform_prompt_wrapper").hide();
  $("#platform_prompt_box").hide(); 
}

function platform_ajax(ajax_object) {
  var xhr = new XMLHttpRequest();
  return new Promise(function(resolve, reject) {
   xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {

        switch (xhr.status) {
          case 200:
            resolve(xhr.responseText);
            break;
          case 403:
            //Forbidden
            var alert_object = {
              title: '<i class="fa fa-exclamation" aria-hidden="true"></i> 403 | Operação Não Autorizada',
              msg: 'Não tem permissões para a realização desta operação.<br>Caso necessite de a realizar, peça ao(s) administrador(es) do website que lhe atribua as permissões necessárias.',
              buttons: [
                {
                  text: 'OK',
                  function: 'platform_alert_close',
                  arguments: '',
                  class: ''
                }
              ]
            };
            platform_alert(alert_object);
            reject(false);

            break;
          case 404:
            //Not Found
            var alert_object = {
              title: '<i class="fa fa-exclamation" aria-hidden="true"></i> 404 | Operação Não Encontrada',
              msg: 'Não foi possível encontrar a operação indicada.',
              buttons: [
                {
                  text: 'OK',
                  function: 'platform_alert_close',
                  arguments: '',
                  class: ''
                }
              ]
            };
            platform_alert(alert_object);
            reject(false);

            break;
          case 500:
            //Internal Server Error
            var alert_object = {
              title: '<i class="fa fa-exclamation" aria-hidden="true"></i> 500 | Problema de Servidor',
              msg: 'Não foi possível realizar esta operação devido a um problema do servidor.',
              buttons: [
                {
                  text: 'OK',
                  function: 'platform_alert_close',
                  arguments: '',
                  class: ''
                }
              ]
            };
            platform_alert(alert_object);
            reject(false);

            break;
          case 0:
            //Network Error
            var alert_object = {
              title: '<i class="fa fa-exclamation" aria-hidden="true"></i> 0 | Problema de Conexão',
              msg: 'Não foi possível realizar desta operação devido a problemas de rede.',
              buttons: [
                {
                  text: 'OK',
                  function: 'platform_alert_close',
                  arguments: '',
                  class: ''
                }
              ]
            };
            platform_alert(alert_object);
            reject(false);

            break;
          default:
            var json = JSON.parse(xhr.responseText);
            console.log(json);

            var alert_object = {
              title: '<i class="fa fa-exclamation" aria-hidden="true"></i> '+json.code+' | '+json.title,
              msg: json.msg,
              buttons: [
                {
                  text: 'OK',
                  function: 'platform_alert_close',
                  arguments: '',
                  class: ''
                }
              ]
            };
            platform_alert(alert_object);
            reject(false);
        }
        
      }
    }
    xhr.open(ajax_object.method, ajax_object.url);
    if (typeof ajax_object.data === 'string') {
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    }      
    xhr.send(ajax_object.data);
  });
}
