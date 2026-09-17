class Editor {

	constructor(element) {
      this.editor = element;
      this.cursor = 0;
    }

    getEditor() {
    	return this.editor;
    }

    getLastCursorPosition() {
    	return this.cursor;
    }

    textChange() {
    	if(this.editor === undefined) {return}
    	var editor = this.editor;

    	this.cursor = Cursor.getCursorPosition(this.editor[0]);;
		var str = this.editor[0].innerHTML;
		var target = this.editor.data('target');
		$("#"+target).val(str);
	}

	styleText(aCommandName, aValueArgument) {
		//this.editor[0].contentWindow.document.execCommand(aCommandName, false, aValueArgument);
		document.execCommand(aCommandName, false, aValueArgument);
		this.textChange();
	}

	addLink(i) {
		var prompt_object = {
	      title: 'Adicionar Link URL',
	      msg: 'Introduza um endereço URL',
	      inputs: [
	        {
	          type: 'text',
	          class: 'bo_cms_link',
	          value: 'http://',
	          label: 'URL:'
	        },
	        {
	          type: 'checkbox',
	          class: 'bo_cms_link_blank',
	          value: '',
	          label: 'Abrir num novo separador?'
	        }
	      ],
	      buttons: [
	        {
	          text: 'Cancelar',
	          function: 'bo_prompt_close',
	          arguments: '',
	          class: 'bo_prompt_cancel'
	        },
	        {
	          text: 'Confirmar',
	          function: 'addCmsLink',
	          arguments: [i],
	          class: ''
	        }
	      ]
	    };

	    bo_prompt(prompt_object);
	}
	

}