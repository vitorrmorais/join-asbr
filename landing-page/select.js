
window.onDomReady = function dgDomReady(fn){
	if(document.addEventListener)	//W3C
		document.addEventListener("DOMContentLoaded", fn, false);
	else 
		document.onreadystatechange = function(){dgReadyState(fn);}
}

function dgReadyState(fn){ 
	if(document.readyState == "interactive") fn();
}

var dgUnidadesRegioes = function(data) {
  var defaultData = {
    regiao: false,
    regiaoVal: '',
    unidade: false,
    unidadeVal: '',
    change: false
  }
  for (name in defaultData) {
    if (!data[name]) {
      data[name] = defaultData[name];
    }
  }
  var keys = ['regiao', 'unidade'];
  if (data['change']) { 
    var nome, length = keys.length;
    for (var a=0; a<length; a++ ) {
      nome = keys[a];
      if (data[nome].tagName) {
        var opt = document.createElement('select');
        opt.disabled = null
        for (var i = 0; i < data[nome].attributes.length ; i++) {
          var attr = data[nome].attributes[i];
          if (attr.name != 'type') {
            opt.setAttribute(attr.name, attr.value);
          }
        }
        opt.size=1;
        opt.disabled=false;
        data[nome].parentNode.replaceChild(opt, data[nome]);
        data[nome] = opt;
      }
    }
  }
  this.set(data['regiao'], data['unidade']);
  this.start();

  var nome, length = keys.length;
  for (var i=0; i<length; i++) {
    nome = keys[i]; 
	
    if (this[nome].getAttribute('value')) {
      data[nome+'Val'] = this[nome].getAttribute('value');
    }
	
    if (data[nome+'Val']) { 
		var options = this[nome].options;
		if (nome=='regiao') this.regiao.onchange(); 
		for (var j = 0; j<options.length; j++) { 
			if (options[j].tagName == 'OPTION') {
				if (options[j].value == data[nome+'Val']) {
					options[j].setAttribute('selected',true);
					if (nome=='regiao'){ 
						this.regiao.selectedIndex=j;
						this.regiao.onchange();
					}
				}
			}
		}
	}
	
  }
  
}

dgUnidadesRegioes.prototype = {
  regiao: document.createElement('select'),
  unidade: document.createElement('select'),
  set: function(regiao, unidade) { 
    this.regiao=regiao;
    this.regiao.dgUnidadesRegioes=this;
    this.unidade=unidade;
    this.regiao.onchange=function(){this.dgUnidadesRegioes.run()};
  },
  start: function () { 
    var regiao = this.regiao;
    while (regiao.childNodes.length) regiao.removeChild(regiao.firstChild);
    for (var i=0;i<this.regioes.length;i++) this.addOption(regiao, this.regioes[i][0], this.regioes[i][1]);
  },
  run: function () { 
	var sel = this.regiao.selectedIndex; 
    var itens = this.unidades[sel]; 
    var itens_total = itens.length;
	
    var opts = this.unidade;
    while (opts.childNodes.length) opts.removeChild(opts.firstChild); 
	
    this.addOption(opts, '', 'Selecione uma unidade');
    for (var i=0;i<itens_total;i++) this.addOption(opts, itens[i], itens[i]); 
  },
  addOption: function (elm, val, text) {
    var opt = document.createElement('option');
    opt.appendChild(document.createTextNode(text));
    opt.value = val;
    elm.appendChild(opt);
  },
  regioes : [
    ['','Selecione uma região'],['Sul','Sul'],['Sudeste','Sudeste'],['Centro-Oeste','Centro-Oeste'],['Nordeste','Nordeste'],['Norte','Norte']
  ],
  unidades : [
	[''],
	 ['Porto Alegre', 'Curitiba'],['São Paulo', 'Rio de Janeiro', 'Belo Horizonte'],['Brasília'],['Salvador', 'Recife'],['Indisponível']
  ]
};