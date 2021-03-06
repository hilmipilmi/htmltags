
�re_sajax_show�

// function saves scroll position
function fScroll(val)
{
    var hidScroll = document.getElementById('hidScroll');
    hidScroll.value = val.scrollTop;
}

// function moves scroll position to saved value
function fScrollMove(what)
{
    var hidScroll = document.getElementById('hidScroll');
    document.getElementById(what).scrollTop = hidScroll.value;
}

var hashListener = {
	ie:		/MSIE/.test(navigator.userAgent),
	ieSupportBack:	true,
	hash:	document.location.hash,
	check:	function () {
		var h = document.location.hash;
		if (h != this.hash) {
			this.hash = h;
			this.onHashChanged();
		}
	},
	init:	function () {

		// for IE we need the iframe state trick
		if (this.ie && this.ieSupportBack) {
			var frame = document.createElement("iframe");
			frame.id = "state-frame";
			frame.style.display = "none";
                        if (document.body) {
			        document.body.appendChild(frame);
			        this.writeFrame("");
                        } else {
                                alert("No document body present\n");
                        }
		}

		var self = this;

		// IE
		if ("onpropertychange" in document && "attachEvent" in document) {
			document.attachEvent("onpropertychange", function () {
				if (event.propertyName == "location") {
					self.check();
				}
			});
		}
		// poll for changes of the hash
		window.setInterval(function () { self.check() }, 100);
	},
	setHash: function (s) {
		// Mozilla always adds an entry to the history
		if (this.ie && this.ieSupportBack) {
			this.writeFrame(s);
		}
		document.location.hash = s;
	},
	getHash: function () {
		return document.location.hash;
	},
	writeFrame:	function (s) {
		var f = document.getElementById("state-frame");
		if (f) {
                    var d = f.contentDocument || f.contentWindow.document;
		    d.open();
		    d.write("<script>window._hash = '" + s + "'; window.onload = parent.hashListener.syncHash;<\/script>");
		    d.close();
                }
	},
	syncHash:	function () {
		var s = this._hash;
		if (s != document.location.hash) {
			document.location.hash = s;
		}
	},
	onHashChanged:	function () {}
};
	  
hashListener.onHashChanged = function () {
	  if (hashListener.hash.length > 0 &&
	      hashListener.hash.substr(0,1) == '#') {
	      var h = hashListener.hash.substr(1);
              var e;
	  //alert(h);
              if (e = document.getElementById(h)) {
	           if (e.style.pixelTop) {
                        window.scrollTo(1,e.style.pixelTop);
                   } else if (e.offsetTop) {
                        window.scrollTo(1,e.offsetTop);
                   } else {
                        window.scrollTo(1,e.style.top);
                        /*e.style.top=y_mouse;
                        e.style.left=x_mouse;*/
                   }
                     
	      } if (e = document.getElementsByName(h)) {
	           if (e.length > 0) {
	           var e = e[0];
	           if (e.style.pixelTop && e.style.pixelLeft) {
                        window.scrollTo(1,e.style.pixelTop);
                   } else if (e.offsetTop) {
                        window.scrollTo(1,e.offsetTop);
                   } else {
                        window.scrollTo(0, e.style.top);
                   }
	           }
   	      }
	  }
};


	  
window.onbeforeunload = function () {
   // stuff do do before the window is unloaded here.
   //	  alert();
}
	  

function showhide(){
if (document.all||document.getElementById){
if (theobject.style.visibility=="hidden"){
doit=setInterval("positionit()",100)
theobject.style.visibility="visible"
}
else{
theobject.style.visibility="hidden"
clearInterval(doit)
}
}
}

function positionit(){
var dsocleft=document.all? iebody.scrollLeft : pageXOffset
var dsoctop=document.all? iebody.scrollTop : pageYOffset
if (document.all||document.getElementById){
theobject.style.left=dsocleft+"px"
theobject.style.top=dsoctop+"px"
theobject.innerHTML='<big>('+dsocleft+','+dsoctop+')</big>'
}
}
		      
var pathdef = {
    b:     "",
    fids:  new Array(�re_fids_idx�),
    paths: new Array()                  
};

var paths = new Array();
�re_pathinit�
	
	      
var x_mouse = 0;
var y_mouse = 0;
var z_index = 0;
var isLoaded = 0;

var isIE = document.all?true:false;

if (!isIE) document.captureEvents(Event.MOUSEMOVE);
document.onmousemove = getMousePosition;

function getMousePosition(e) {
        var _x;
        var _y;
        if (!isIE) {
                x_mouse = e.pageX;
                y_mouse = e.pageY;
        }
        if (isIE) {
                x_mouse = document.body.scrollLeft+event.x;
                y_mouse = document.body.scrollTop+event.y;
        }
        return true;
}

function getObj(name) {

        if (document.getElementById){
                this.obj = document.getElementById(name);
                this.style = document.getElementById(name).style;
        } else if (document.all) {
                this.obj = document.all[name];
                this.style = document.all[name].style;
        } else if (document.layers) {
                if (document.layers[name]) {
                        this.obj = document.layers[name];
                        this.style = document.layers[name];
                }
        } else {
                this.obj = document.layers.testP.layers[name];
                this.style = document.layers.testP.layers[name];
        }
}


function totop(treepart) {
        var x = new getObj("T"+treepart);
        x.style.zIndex=z_index++;
}

function show(treepart) {
        if (isLoaded == 0) {
                //display warning
                var x = new getObj("T100000");
                if (x.style.pixelTop && x.style.pixelLeft) {
                        x.style.pixelTop=y_mouse;
                        x.style.pixelLeft=x_mouse;
                } else {
                        x.style.top=y_mouse;
                        x.style.left=x_mouse;
                }
                x.style.zIndex=z_index++;
                x.style.visibility="";
         } else {
                 var x = new getObj("T"+treepart);

                 if (x.style.pixelTop && x.style.pixelLeft) {
                         x.style.pixelTop=y_mouse;
                         x.style.pixelLeft=x_mouse;
                 } else {
                         x.style.top=y_mouse;
                         x.style.left=x_mouse;
                 }
                 x.style.zIndex=z_index++;
                 x.style.visibility="";
         }
}

function hide(treepart) {
        if (isLoaded == 1 || treepart == 100000) {
                var x = new getObj("T"+treepart);
                x.style.visibility="hidden";
        }
}

function setPos(anchor,obj){
         if (isLoaded == 0) {
         } else {
                 var x = new getObj(anchor);
                 var newX = findPosX(x.obj);
                 var newY = findPosY(x.obj);
                 var y = new getObj(obj);
                 y.style.left = newX + 'px';
                 y.style.top = newY + 'px';
         }
         return 1;
}

function findPosX(obj){
        var curleft = 0;
        if (obj.offsetParent) {
                while (obj.offsetParent) {
                        curleft += obj.offsetLeft
                        obj = obj.offsetParent;
                }
        }
        else if (obj.x)
                curleft += obj.x;
        return curleft;
}

function findPosY(obj){
         var curtop = 0;
         if (obj.offsetParent) {
                 while (obj.offsetParent){
                         curtop += obj.offsetTop
                         obj = obj.offsetParent;
                 }
         }
         else if (obj.y)
                 curtop += obj.y;
         return curtop;
}
      


var closednodes = new Array();

      
function replace(obj,str) {
        if (isIE) {              
               str = str.replace(/%0A/g,"<br/>");
        }
        obj.innerHTML = unescape(str);
}


function replaceXML_onload(xmlDoc, xmlid, obj) {
	var onextID = nextID++;
        var x = xmlDoc.getElementsByTagName(xmlid);
        if (x.length > 0 &&
            x[0].childNodes.length > 0 &&
            x[0].nodeType == 1) {
                var y = x[0].getElementsByTagName('line');
                if (y.length > 0 &&
                    y[0].childNodes.length > 0 &&
                    y[0].childNodes[0].nodeType == 3) {
                        var str = new String();
                        for (j=0;j<y.length;j++) {
                                for (k=0;k< y[j].childNodes.length;k++) {
                                        str += y[j].childNodes[k].nodeValue;
                                }
                        }
			str = str.replace(/--xmlid--/g,onextID+".");
                        replace(obj,str);
		}
        } else {
                replace(obj,"<span class=\"parseerror\">Error: Element "+xmlid+" not found</span>");
        }
}

function replaceXML(fileid,xmlid,obj,finish,arg) {

	if (document.implementation && document.implementation.createDocument)
	{
		var xmlDoc = document.implementation.createDocument("", "", null);
		xmlDoc.onload = function() {
                        if ("parsererror" == xmlDoc.documentElement.nodeName) {
                                replace(obj,"<span class=\"parseerror\">Parse error: "+xmlDoc.documentElement.firstChild.nodeValue+"</span>");
			} else {
                                replaceXML_onload(xmlDoc, xmlid, obj);
				if (typeof(finish) == 'function') {
					  finish(arg);
			        }
                        }
                };
	        xmlDoc.load(fileid);
	}
	else if (window.ActiveXObject)
	{
		var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.onreadystatechange = function() {
	                if (xmlDoc.readyState == 4) {
                                replaceXML_onload(xmlDoc, xmlid, obj);
				if (typeof(finish) == 'function') {
					  finish(arg);
			        }
                        }
                };
	        if (!xmlDoc.load(fileid)) {
                         replace(obj,"<span class=\"parseerror\">Parse error: "+
                                    "errorCode: " + xmlDoc.parseError.errorCode + "\n" +
                                    "filepos: "   + xmlDoc.parseError.filepos + "\n" +
                                    "line: "      + xmlDoc.parseError.line + "\n" +
                                    "linepos: "   + xmlDoc.parseError.linepos + "\n" +
                                    "reason: "    + xmlDoc.parseError.reason + "\n" +
                                    "srcText: "   + xmlDoc.parseError.srcText + "\n" +
                                    "url: "       + xmlDoc.parseError.url +"</span>");
                }
        }
	else
	{
		alert('Your browser cant handle load through XMLDOM');
		return;
	}
}

/* called from registerd open/close path's */
function replaceXMLpath(fileid,xmlid,id,finish,arg) {
        var div = document.getElementById(id);
	var style = new String();
	style = xmlid.substr(style.length-1,1);
	var n = div.className;				    
        if( n == 'fincmarke' &&
	    style == "e") {
		if (typeof(finish) == 'function') {
		     finish(arg);
	        }				    
		return;
	}
	replaceXML(fileid,xmlid,div,finish,arg);
	markdiv(div,xmlid);
}	

/* called from registerd open/close path's */
function replaceAJAXpath(fileid,xmlid,id,finish,arg) {
	var onextID = nextID++;
        var div = document.getElementById(id);
	var style = new String();
	style = xmlid.substr(style.length-1,1);
	var n = div.className;				    
        if( n == 'fincmarke' &&
	    style == "e") {
		if (typeof(finish) == 'function') {
		     finish(arg);
	        }				    
		return;
	}
        x_getdbentry(fileid,xmlid, function (data) {
            data = data.replace(/--xmlid--/g,onextID+".");
            replace(div,data);
            if (typeof(finish) == 'function') {
		finish(arg);
	    }
        });
	markdiv(div,xmlid);
}	


function markdiv(div,xmlid) {					    
	if (div.className == 'fincmarku' ||
            div.className == 'fincmarke') {
                var style = new String(xmlid);
                div.className = 'fincmark'+style.substr(style.length-1,1);
        }				    
}
					    
function replaceXMLspan(elem,fileid,xmlid) {
        var span = replaceXMLelem("span",elem,fileid,xmlid);
        if (span != null) {
                if (span.className == 'macrou' ||
                    span.className == 'macroe') {
                        var style = new String(xmlid);
                        span.className = 'macro'+style.substr(style.length-1,1);
                }
        }
}

function replaceAJAXspan(elem,fileid,xmlid) {
        var span = replaceAJAXelem("span",elem,fileid,xmlid);
        if (span != null) {
                if (span.className == 'macrou' ||
                    span.className == 'macroe') {
                        var style = new String(xmlid);
                        span.className = 'macro'+style.substr(style.length-1,1);
                }
        }
}

/* called from interactive link */
function replaceXMLdiv(elem,fileid,xmlid) {
        var mode = xmlid.substr(xmlid.length-1,1);
        if (mode != 'e' && mode != 'u') {
            alert("Unknown mode "+mode+" from "+xmlid);
        } else {
            var div = find_ancestor(elem,"div");
            if (div == null) {
		return;
	    }
            replaceXML(fileid,xmlid,div, function() {
                if (mode == 'e') {
		    if (top.idx)  {
                        top.idx.open('',xmlid.substr(1,xmlid.length-2));
		    }
                } else {
                    if (top.idx)  {
                        top.idx.close('',xmlid.substr(1,xmlid.length-2));
		    }
                } 
            }, mode);					    
            markdiv(div,xmlid);
        }
}

/* called from interactive link */
function replaceAJAXdiv(elem,fileid,xmlid) {
	var onextID = nextID++;
        var mode = xmlid.substr(xmlid.length-1,1);
        if (mode != 'e' && mode != 'u') {
            alert("Unknown mode "+mode+" from "+xmlid);
        } else {
            var div = find_ancestor(elem,"div");
            if (div == null) {
		return;
	    }
            x_getdbentry(fileid,xmlid, function (data) {
                    data = data.replace(/--xmlid--/g,onextID+".");
                    replace(div,data)
                    if (mode == 'e') {
			if (top.idx) {
			    top.idx.open('',xmlid.substr(1,xmlid.length-2));
			}
                    } else {
			if (top.idx) {
			    top.idx.close('',xmlid.substr(1,xmlid.length-2));
			}
                    }
            });
            markdiv(div,xmlid);
        }
}


function replaceSpan(elem,str) {
        var span = find_ancestor(elem,"span");
        if (span == null) {
		return;
	}
	span.innerHTML = unescape(str);
}

function replaceXMLelem(tag,elem,fileid,xmlid) {
        var obj = find_ancestor(elem,tag);
        if (obj != null) {
                replaceXML(fileid,xmlid,obj);
        }
        return obj;
}


function replaceAJAXelem(tag,elem,fileid,xmlid) {
	var onextID = nextID++;
        var obj = find_ancestor(elem,tag);
        if (obj != null) {
                x_getdbentry(fileid,xmlid, function (data) {
                    data = data.replace(/--xmlid--/g,onextID+".");
                    replace(obj,data)
                    
                });
        }
        return obj;
}

function obj(menu)
{
    return (navigator.appName == "Microsoft Internet Explorer")?this[menu]:document.getElementById(menu);
}

function array_contains(nodes,obj) {
    for (var i = 0; i < nodes.length; i++) {
        if (nodes[i].toString() == obj.toString()) {
           return i;
	}
    }
    return -1;
}
function array_remove(nodes,obj) {
    var index = array_contains(nodes,obj);
    if(index > -1)
        nodes.splice(index, 1);
}
function array_add(nodes,obj) {
    var index = array_contains(nodes,obj);
    if(index == -1)
        nodes.push(obj);
}

function expand(treepart) {

        togglevisible(treepart+"u");
        togglevisible(treepart+"e");
}

function toggleshow(treepart,finish,arg) {

    if (this.obj("T"+treepart) && this.obj("T"+treepart).style.visibility == "hidden")
    {
        if (pathdef.paths[treepart]) {
	    if (top.idx) {
		top.idx.open('',pathdef.paths[treepart].id);
	    }
        }
        this.obj("T"+treepart).style.position="";
        this.obj("T"+treepart).style.visibility="";
        /*document["I"+treepart].src="/mediawiki/images/stats_visible.gif";*/
    }
    if (typeof(finish) == 'function') {
	finish(arg);
    }
}

function togglehide(treepart,finish,arg) {

    if (this.obj("T"+treepart) && this.obj("T"+treepart).style.visibility != "hidden") {
        if (pathdef.paths[treepart]) {
	    if (top.idx) {
		top.idx.close('',pathdef.paths[treepart].id);
	    }
        }
        this.obj("T"+treepart).style.position="absolute";
        this.obj("T"+treepart).style.visibility="hidden";
        /*document["I"+treepart].src="/mediawiki/images/stats_hidden.gif";*/
    }
    if (typeof(finish) == 'function') {
	finish(arg);
    }
}

function togglevisible(treepart) {
    if (this.obj("T"+treepart).style.visibility == "hidden") {
        toggleshow(treepart);
    } else {
        togglehide(treepart);
    }
}

function find_ancestor(obj,tag) {
    var parent = obj;
    while (1) {
        parent = parent.parentNode;
	if (parent == null)
	    return null;
	if (parent.tagName == tag.toLowerCase() || parent.tagName == tag.toUpperCase())
            return parent;
      	if (parent.tagName == 'HTML' || parent.tagName == 'html')
            return null;
    }
}

function gotolocation_onload()  {
	var query = (location.href.indexOf("?")+1);
	if (query) {
		var idx = location.href.substr(query);
		if (idx.substr(0,1) == 'D' &&
		    idx.substr(idx.length-2) == "ue") {
			var target = parseInt(idx.substr(1,idx.length-3))+'';
			if (typeof(pathdef.paths[target]) != 'undefined') {
				var path = pathdef.paths[target].o;
				var c = new Array();
				for (i in path) {
					c.push(path[i]);    
				}
			        traversepath(c);
			}
		} else if ( idx.match(/open_([0-9]+)_([0-9]+)/) ) {
			var fid = RegExp.$1;
			var id = RegExp.$2;
			setTimeout(function() {
		           gotolocationopen(0,0,fid,id);
	                }, 10);
		} else {
		     alert ("cant decode "+idx);
                }
	}
}

function locationclose(fid) {
        if (pathdef.paths[fid]) {                                            
	    var path = pathdef.paths[fid].c;
	    var c = new Array();
	    for (i in path) {
		c.push(path[i]);    
	    }
            if (top.location != location &&
                top.idx) {
                c.push("top.idx.close('','"+pathdef.paths[fid].id+"'");    
            }
	    traversepath(c);
        }
}

function locationopen(fid) {
        if (pathdef.paths[fid]) {                                            
	    var path = pathdef.paths[fid].o;
	    var c = new Array();
	    for (i in path) {
		c.push(path[i]);    
	    }
            if (top.location != location &&
                top.idx) {
                c.push("top.idx.open('','"+pathdef.paths[fid].id+"'");    
            }
	    traversepath(c);
        }
}

function gotolocationopen(elem,sid, fid,id) {
        if (pathdef.paths[fid]) {                                            
	    var path = pathdef.paths[fid].o;
	    var c = new Array();
	    c.push("gotolocation("+sid);    				    
	    for (i in path) {
		c.push(path[i]);    
	    }
	    c.push("gotolocation("+id);    				    
	    traversepath(c);
        }
}

function gotolocation(id,finish,arg) {
        //alert (location);                                    
	if (document.getElementById(id)) {				    
	   // document.location.href = '#' + id;
	   //location =   '#' + id;				    
	   location.hash =   id;				    
	} if (document.getElementsByName(id)) {				    
	    //document.location.href = '#' + id;
	   //location =  '#' + id;				    
	   location.hash =  id;				    
	}
	if (typeof(finish) == "function") {
		finish(arg);
	}				    
}
					    
function traversepath(path)  {
	if (path.length > 0) {				    
	    var p = path.shift();
	    p += ", traversepath, path);";
	    eval(p);
	}
}



///////////////////////////////////////////////////

// Nice, handy strprintf for javascript
function jstrprintf() {
    len = arguments.length;
    if (len == 0) { return; }
    if (len == 1) { return arguments[0]; }
    
    var result;
    var regexstr;
    var replstr;
    var formatstr;
    var re;
    
    result = "";
    regexstr = "";
    replstr = "";
    formatstr = arguments[0];
    
    for (var i=1; i<arguments.length; i++) {
        replstr += String(i+100) + arguments[i]  + String(i + 100);
        regexstr += String(i+100) + "(.*)" + String(i+100);
    }
    re = new RegExp(regexstr);
    var result;
    result = replstr.replace(re, formatstr);
    return result;
}

function AddPx(num) {
    return String(num) + "px";
}

function findParentDiv(obj) {
    while (obj) {
        if (obj.tagName.toUpperCase() == "DIV") {
            return obj;
        }
        
        if (obj.parentElement) {
            obj = obj.parentElement;
        }
        else {
            return null;
        }
    }
    return null;
}

function findParentTagById(obj, parentname) {
    while (obj) {
        if (obj.id.match(parentname)) {
            return obj;
        }
        
        if (obj.parentElement) {
            obj = obj.parentElement;
        }
        else {
            return null;
        }
    }
    return null;
}

// Now for the real thing

var topZ = 1;
var startX;
var startY;
startX = 100;
startY = 100;
nextID = 1;


function DL_GetElementLeft(eElement)
{
    if (!eElement && this)                       // if argument is invalid
    {                                            // (not specified, is null or is 0)
        eElement = this;                         // and function is a method
    }                                            // identify the element as the method owner
    
    var nLeftPos = eElement.offsetLeft;          // initialize var to store calculations
    var eParElement = eElement.offsetParent;     // identify first offset parent element  
    while (eParElement != null)
    {                                            // move up through element hierarchy
        nLeftPos += eParElement.offsetLeft;      // appending left offset of each parent
        eParElement = eParElement.offsetParent;  // until no more offset parents exist
    }
    return nLeftPos;                             // return the number calculated
}


function DL_GetElementTop(eElement)
{
    if (!eElement && this)
    {
        eElement = this;
    }

    var nTopPos = eElement.offsetTop;
    var eParElement = eElement.offsetParent;
    while (eParElement != null)
    {
        nTopPos += eParElement.offsetTop;
        eParElement = eParElement.offsetParent;
    }
    return nTopPos;
}

var divid = 0;
function showstruct( thisid, id) {
        //alert(document.defaultView.getComputedStyle(document.getElementById(thisid),'').getPropertyValue('top'));
        CreateDropdownWindow( document.getElementById('A'+thisid) ,"struct", id, true /*false*/);
}

function showxmlstruct(thisid, fileid, id) {
        var div = CreateDropdownWindow(getElementById('A'+thisid), "struct", id, true /*false*/);
        replaceXML(fileid,'S'+id, div);				       
          //document.getElementById('A'+thisid)
}

function showtool( thisid, args) {
        var onextID = nextID;
        var argno = showtool.arguments.length-1;
        //alert(document.defaultView.getComputedStyle(document.getElementById(thisid),'').getPropertyValue('top'));
        var tools = CreateDropdownWindow( document.getElementById('A'+thisid) ,"struct", argno , true /*false*/);
	for (i = 1; i < showtool.arguments.length; i++) {
                if (showtool.arguments[i]) {
                    var elemid = showtool.arguments[i];
                    var elem = document.getElementById(elemid);
                    if (elem) {
                        var html = elem.innerHTML;                                
                        html = html.replace(/--xmlid--/g,onextID+".");
                        replace(tools[i-1],html);
                    }
                }
        }
}

function showxmltool(thisid, args) {
        var onextID = nextID;
        var argno = ((showxmltool.arguments.length-1) / 2);
        //alert(document.defaultView.getComputedStyle(document.getElementById(thisid),'').getPropertyValue('top'));
        var tools = CreateDropdownWindow( document.getElementById('A'+thisid) ,"struct", argno, true /*false*/);
	for (i = 0; i < argno; i++) {
                var fileid = showxmltool.arguments[1+i*2];
                var elemid = showxmltool.arguments[1+i*2+1];
                replaceXML(fileid,elemid, tools[i]);				       
        }
}

function getdbentry_func(onextID,fileid,elemid,rep) {
	var repobj = rep; var id = onextID; 
	x_getdbentry(fileid,elemid, function (data) {
		data = data.replace(/--xmlid--/g,id+".");
                replace(repobj,data)
         });		
}
			
function showajaxtool(thisid, args) {
        var onextID = nextID;
        var argno = ((showajaxtool.arguments.length-1) / 2);
        //alert(document.defaultView.getComputedStyle(document.getElementById(thisid),'').getPropertyValue('top'));
        var tools = CreateDropdownWindow( document.getElementById('A'+thisid) ,"struct", argno, true /*false*/);
	for (var i = 0; i < argno; i++) {
                var fileid = showajaxtool.arguments[1+i*2];
                var elemid = showajaxtool.arguments[1+i*2+1];
                var repobj = tools[i];
		getdbentry_func(onextID++,fileid,elemid,repobj);
			    
		//	    alert(repobj.id);
                /*x_getdbentry(fileid,elemid, function (data) {
                    data = data.replace(/--xmlid--/g,onextID+".");
			    alert(repobj.id);
                    replace(repobj,data)
                });*/
        }
}


function CreateDropdownWindow(relobj, caption, length, canMove) {
    var newdiv;
    var ret = new Array();
   
    //CloseContentWin(id);

    startX = x_mouse;
    startY = y_mouse;
    
    if (relobj) {
        var left = DL_GetElementLeft(relobj);                              
        var top = DL_GetElementTop(relobj);
        var height = relobj.offsetHeight;
        startX = left;
        startY = top+height;
    }                              
                                      
    newdiv = document.createElement("div");
    newdiv.id = "dragTitle" + String(nextID);
    newdiv.className = "divDragTitle";
    newdiv.style.width = 'auto'; //theWidth;
    newdiv.style.left = AddPx(startX);
    newdiv.style.top = AddPx(startY);
    newdiv.style.zIndex = topZ;

    newdiv.innerHTML =   
     '<a class="dragbutton"  href="javascript:CloseContentWin('+nextID+')">[x]</a><a class="dragbutton" href="javascript:toggleContentWin('+nextID+')">[-]</a>'
     +'<span class="dragcaption">'+caption+'</span>';
    ;
    
    // If canMove is false, don't register event handlers
    if (canMove) {
        // IE doesn't support addEventListener, so check for its presence
        if (newdiv.addEventListener) {
            // firefox, etc.
            newdiv.addEventListener("mousemove", function(e) { return mouseMove(e) }, true);
            newdiv.addEventListener("mousedown", function(e) { return mouseDown(e) }, true);
            newdiv.addEventListener("mouseup", function(e) { return mouseUp(e) }, true);
        }
        else {
            // IE
            newdiv.attachEvent("onmousemove", function(e) { return mouseMove(e) });
            newdiv.attachEvent("onmousedown", function(e) { return mouseDown(e) });
            newdiv.attachEvent("onmouseup", function(e) { return mouseUp(e) });
        }
    }
    document.body.appendChild(newdiv);

    for (i = 0; i < length; i++) {
        var newdiv2;
        newdiv2 = document.createElement("div");
        newdiv2.id = "dragContent" + String(nextID); nextID++;
        newdiv2.className = "divDragContent";
        //newdiv2.style.width = 'auto';
        newdiv2.style.left = AddPx(startX);
        newdiv2.style.top = AddPx(startY + 10);
        newdiv2.style.zIndex = topZ;
        
        if (canMove) {
        if (newdiv2.addEventListener) {
            // firefox, etc.
            newdiv2.addEventListener("mousedown", function(e) { return contentMouseDown(e) }, true);
        }
        else {
            // IE
            newdiv2.attachEvent("onmousedown", function(e) { return contentMouseDown(e) });
        }
        }
        newdiv.appendChild(newdiv2);
        ret.push(newdiv2);
    }
                                      
    //document.body.appendChild(newdiv2);
    
    // Save away the content DIV into the title DIV for 
    // later access, and vice versa
    newdiv.content = newdiv2;
    newdiv2.titlediv = newdiv;

    topZ += 1;
    startX += 25;
    startY += 25;
    // If you want you can check when these two are greater than
    // a certain number and then rotate them back to 100,100...
    
    nextID++;
    return ret;				      
}

function toggleContentWin(id) {
    var elem = document.getElementById("dragContent" + String(id));
    var img = document.getElementById("dragButton" + String(id));

    if (elem.style.display == "none") {
        // hidden, so unhide
        elem.style.display = "block";
        
        // Change the button's image
        img.src = "buttontop.gif";
    } else {
        // showing, so hide
        elem.style.display = "none";

        // Change the button's image
        img.src = "buttonbottom.gif";
    }
}

function CloseContentWin(id) {
    var elem = document.getElementById("dragTitle" + String(id));
    if (elem) {
        elem.parentNode.removeChild(elem);
    } 
}

// Drag methods
var dragObjTitle = null;
var dragOffsetX = 0;
var dragOffsetY = 0;

function contentMouseDown(e) {
    // Move the window to the front
    // Use a handy trick for IE vs FF
    var dragContent = e.srcElement || e.currentTarget;
    if ( ! dragContent.id.match("dragContent")) {
        dragContent = findParentTagById(dragContent, "dragContent");
    }
    if (dragContent) {
        dragContent.style.zIndex = topZ;
        if (dragContent.titlediv) {
	    dragContent.titlediv.style.zIndex = topZ;
	}
        topZ++;
    }
}

function mouseDown(e) {
    // These first two lines are written to handle both FF and IE
    var curElem = e.srcElement || e.target;
    var dragTitle = e.currentTarget || findParentDiv(curElem);
    if (dragTitle) {
        if (dragTitle.className != 'divDragTitle') {
            return;
        }
    }
    
    // Start the drag, but first make sure neither is null
    if (curElem && dragTitle) {
    
        // Attach the document handlers. We don't want these running all the time.
        addDocumentHandlers(true);
    
        // Move this window to the front.
        dragTitle.style.zIndex = topZ;
        dragTitle.content.style.zIndex = topZ;
        topZ++;
    
        // Check if it's the button. If so, don't drag.
        if (curElem.className != "divTitleButton") {
            
            // Save away the two objects
            dragObjTitle = dragTitle;
            
            // Calculate the offset
            dragOffsetX = e.clientX - 
                dragTitle.offsetLeft;
            dragOffsetY = e.clientY - 
                dragTitle.offsetTop;
                
            // Don't let the default actions take place
            if (e.preventDefault) {
                e.preventDefault();
            }
            else {
                document.onselectstart = function () { return false; };
                e.cancelBubble = true;
                return false;
            }
        }
    }
}

function mouseMove(e) {
    // If not null, then we're in a drag
    if (dragObjTitle) {
    
        if (!e.preventDefault) {
            // This is the IE version for handling a strange
            // problem when you quickly move the mouse
            // out of the window and let go of the button.
            if (e.button == 0) {
                finishDrag(e);
                return;
            }
        }
    
        dragObjTitle.style.left = AddPx(e.clientX - dragOffsetX);
        dragObjTitle.style.top = AddPx(e.clientY - dragOffsetY);
        dragObjTitle.content.style.left = AddPx(e.clientX - dragOffsetX);
        dragObjTitle.content.style.top = AddPx(e.clientY - dragOffsetY + 20);
        if (e.preventDefault) {
            e.preventDefault();
        }
        else {
            e.cancelBubble = true;
            return false;
        }
    }
}

function mouseUp(e) {
    if (dragObjTitle) {
        finishDrag(e);
    }
}

function finishDrag(e) {
    var finalX = e.clientX - dragOffsetX;
    var finalY = e.clientY - dragOffsetY;
    if (finalX < 0) { finalX = 0 };
    if (finalY < 0) { finalY = 0 };

    dragObjTitle.style.left = AddPx(finalX);
    dragObjTitle.style.top = AddPx(finalY);
    dragObjTitle.content.style.left = AddPx(finalX);
    dragObjTitle.content.style.top = AddPx(finalY + 20);
    
    // Done, so reset to null
    dragObjTitle = null;
    addDocumentHandlers(false);
    if (e.preventDefault) {
        e.preventDefault();
    }
    else {
        document.onselectstart = null;
        e.cancelBubble = true;
        return false;
    }
}

function addDocumentHandlers(addOrRemove) {
    if (addOrRemove) {
        if (document.body.addEventListener) {
            // firefox, etc.
            document.addEventListener("mousedown", function(e) { return mouseDown(e) }, true);
            document.addEventListener("mousemove", function(e) { return mouseMove(e) }, true);
            document.addEventListener("mouseup", function(e) { return mouseUp(e) }, true);
        }
        else {
            // IE
            document.onmousedown = function() { mouseDown(window.event) } ;
            document.onmousemove = function() { mouseMove(window.event) } ;
            document.onmouseup = function() { mouseUp(window.event) } ;
        }
    }
    else {
        if (document.body.addEventListener) {
            // firefox, etc.
	    /*if (remove) {
                remove.addEventListener("mousedown", function(e) { return mouseDown(e) }, true);
                remove.addEventListener("mousemove", function(e) { return mouseMove(e) }, true);
                remove.addEventListener("mouseup", function(e) { return mouseUp(e) }, true);
	    }*/
        }
        else {
            // IE
            // Be careful here. If you have other code that sets these events,
            // you'll want this code here to restore the values to your other handlers,
            // rather than just clear them out.
            document.onmousedown = null;
            document.onmousemove = null;
            document.onmouseup = null;
        }
    }
}

						 
