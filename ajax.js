var ind;
function submitForm (proc)
{
  var req = null;
  document.getElementById ("dest").innerHTML = "Waiting...";
  if (window.XMLHttpRequest)
  	req = new XMLHttpRequest();
  else
    if (window.ActiveXObject)
    {
	  try
	  {
	    req = new ActiveXObject ("Msxml2.XMLHTTP");
	  }
	  catch (e)
	  {
		try
		{
		  req = new ActiveXObject ("Microsoft.XMLHTTP");
		}
		catch (e)
		{
		}
	  }
	}
	req.onreadystatechange = function ()
	{
	  if (req.readyState == 4)
		if (req.status == 200)
		  document.getElementById ("dest").innerHTML = req.responseText;
		else
          document.getElementById ("dest").innerHTML = "Error: returned status code "
			+ req.status + " " + req.statusText;
	};
	ind = $("#ind").val ();
	var url = "dinamic" + proc + ".php?ind=" + escape (ind);
	console.log (" url: " + url);
	req.open ("GET", url, true);
	req.send (null);
}

var ind;
var ind1;
function submitForm1 (proc)
{
  var req = null;
  document.getElementById ("dest1").innerHTML = "Waiting...";
  if (window.XMLHttpRequest)
    req = new XMLHttpRequest();
  else
    if (window.ActiveXObject)
    {
	  try
	  {
	    req = new ActiveXObject ("Msxml2.XMLHTTP");
      }
	  catch (e)
	  {
	    try
	    {
		  req = new ActiveXObject ("Microsoft.XMLHTTP");
	    }
	    catch (e)
	    {
	    }
	  }
    }
  req.onreadystatechange = function ()
  {
    if (req.readyState == 4)
	  if (req.status == 200)
	    document.getElementById ("dest1").innerHTML = req.responseText;
	  else
        document.getElementById ("dest1").innerHTML = "Error: returned status code "
		+ req.status + " " + req.statusText;
  };
  ind = $("#ind").val ();
  ind1 = $("#ind1").val ();
  var url="dinamic1"+proc+".php?ind=" + escape (ind) + "&ind1=" + escape (ind1);
  req.open("GET", url, true);
  req.send(null);
}

function addLinkToFile (cursor, mode, text, rel_id)
{
  if (mode == "links")
  {
    link = prompt ("Введите адрес сайта, на который будет ссылаться текст");
    if (link)
    {
      var req = null;
	  document.getElementById ("dest2").innerHTML = "Waiting...";
	  if (window.XMLHttpRequest)
	    req = new XMLHttpRequest();
	  else
	    if (window.ActiveXObject)
	    {
	      try
		  {
		    req = new ActiveXObject ("Msxml2.XMLHTTP");
	      }
		  catch (e)
		  {
		    try
		    {
		      req = new ActiveXObject ("Microsoft.XMLHTTP");
		    }
		    catch (e)
		    {
		    }
		  }
	    }
	    req.onreadystatechange = function ()
	    {
	      if (req.readyState == 4)
		    if (req.status == 200)
	          document.getElementById ("dest2").innerHTML = req.responseText;
		    else
	          document.getElementById ("dest2").innerHTML = "Error: returned status code "
			  + req.status + " " + req.statusText;
	    };
	    var url="addLink147.php?cursor=" + cursor + "&link=" + link + "&text=" + text + "&rel_id=" + rel_id;
	    req.open("GET", url, true);
	    req.send(null);
    }
  }
  if (mode == "images")
  {
	{
	  var req = null;
	  document.getElementById ("dest3").innerHTML = "Waiting...";
	  if (window.XMLHttpRequest)
	    req = new XMLHttpRequest();
	  else
	    if (window.ActiveXObject)
	    {
	      try
		  {
		    req = new ActiveXObject ("Msxml2.XMLHTTP");
	      }
		  catch (e)
		  {
		    try
		    {
		      req = new ActiveXObject ("Microsoft.XMLHTTP");
		    }
		    catch (e)
		    {
		    }
		  }
	    }
	  req.onreadystatechange = function ()
	  {
		if (req.readyState == 4)
		  if (req.status == 200)
		    document.getElementById ("dest3").innerHTML = req.responseText;
		  else
			document.getElementById ("dest3").innerHTML = "Error: returned status code "
			  + req.status + " " + req.statusText;
	  };
	  var url="addPhotoBio147.php?cursor=" + cursor + "&rel_id=" + rel_id;
	  req.open("GET", url, true);
	  req.send(null);
	}
  }
}

function addLinkToFile1 ()
{
	alert (0);
	}

function removeMark (relative, photo)
{
  var req = null;
  document.getElementById ("dest5").innerHTML = "Waiting...";
  if (confirm ("Вы уверены, что хотите стереть эту отметку?"))
  {
    if (window.XMLHttpRequest)
      req = new XMLHttpRequest();
    else
      if (window.ActiveXObject)
      {
	    try
	    {
	      req = new ActiveXObject ("Msxml2.XMLHTTP");
        }
	    catch (e)
	    {
	      try
	      {
		    req = new ActiveXObject ("Microsoft.XMLHTTP");
	      }
	      catch (e)
	      {
	      }
	    }
      }
    req.onreadystatechange = function ()
    {
      if (req.readyState == 4)
	    if (req.status == 200)
	      document.getElementById ("dest5").innerHTML = req.responseText;
	    else
          document.getElementById ("dest5").innerHTML = "Error: returned status code "
		  + req.status + " " + req.statusText;
    };
    var url="removeMarkX147.php?relative=" + relative + "&photo=" + photo;
    req.open("GET", url, true);
    req.send(null);
  }
}

function addPhoto (photo, account, id, showMark)
{
  var req = null;
  document.getElementById ("dest5").innerHTML = "Waiting...";
    if (window.XMLHttpRequest)
      req = new XMLHttpRequest();
    else
      if (window.ActiveXObject)
      {
	    try
	    {
	      req = new ActiveXObject ("Msxml2.XMLHTTP");
        }
	    catch (e)
	    {
	      try
	      {
		    req = new ActiveXObject ("Microsoft.XMLHTTP");
	      }
	      catch (e)
	      {
	      }
	    }
      }
    req.onreadystatechange = function ()
    {
      if (req.readyState == 4)
	    if (req.status == 200)
	      document.getElementById ("dest5").innerHTML = req.responseText;
	    else
          document.getElementById ("dest5").innerHTML = "Error: returned status code "
		  + req.status + " " + req.statusText;
    };
    var url="apitm147.php?photo=" + photo + "&account=" + account + "&id=" + id + "&showMark=" + showMark;
    req.open("GET", url, true);
    req.send(null);
}

function returnPhoto (photo)
{
  var req = null;
  document.getElementById ("dest6").innerHTML = "Waiting...";
    if (window.XMLHttpRequest)
      req = new XMLHttpRequest();
    else
      if (window.ActiveXObject)
      {
	    try
	    {
	      req = new ActiveXObject ("Msxml2.XMLHTTP");
        }
	    catch (e)
	    {
	      try
	      {
		    req = new ActiveXObject ("Microsoft.XMLHTTP");
	      }
	      catch (e)
	      {
	      }
	    }
      }
    req.onreadystatechange = function ()
    {
      if (req.readyState == 4)
	    if (req.status == 200)
	      document.getElementById ("dest6").innerHTML = req.responseText;
	    else
          document.getElementById ("dest6").innerHTML = "Error: returned status code "
		  + req.status + " " + req.statusText;
    };
    var url="returnPhoto147.php?photo=" + photo;
    req.open("GET", url, true);
    req.send(null);
}

function changeBio ()
{
  //alert ($("[name=visHid]").val())
  var req = null;
  document.getElementById ("dest7").innerHTML = "Waiting...";
    if (window.XMLHttpRequest)
      req = new XMLHttpRequest();
    else
      if (window.ActiveXObject)
      {
	    try
	    {
	      req = new ActiveXObject ("Msxml2.XMLHTTP");
        }
	    catch (e)
	    {
	      try
	      {
		    req = new ActiveXObject ("Microsoft.XMLHTTP");
	      }
	      catch (e)
	      {
	      }
	    }
      }
    req.onreadystatechange = function ()
    {
      if (req.readyState == 4)
	    if (req.status == 200)
	      document.getElementById ("dest7").innerHTML = req.responseText;
	    else
          document.getElementById ("dest7").innerHTML = "Error: returned status code "
		  + req.status + " " + req.statusText;
    };
    var url="changeBio147.php?bio=" + $("#bio1").html();
    req.open("GET", url, true);
    req.send(null);
}