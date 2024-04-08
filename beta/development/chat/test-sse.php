<html>
<head>
   <meta charset="UTF-8">
   <title>Server-sent events demo</title>
</head>
<body>
  <button>Close the connection</button>

  <ul>
  </ul>

<script>
  var button = document.querySelector('button');
  var evtSource = new EventSource('demo_sse.php?val=satu');
  console.log(evtSource.withCredentials);
  console.log(evtSource.readyState);
  console.log(evtSource.url);
  var eventList = document.querySelector('ul');

  evtSource.onopen = function() {
    console.log("Connection to server opened.");
  };

  evtSource.onmessage = function(e) {
    var newElement = document.createElement("li");

    newElement.textContent = "message: " + e.data;
    eventList.appendChild(newElement);
  }

  evtSource.onerror = function() {
    console.log("EventSource failed.");
  };

  button.onclick = function() {
    console.log('Connection closed');
    evtSource.close();
  }

  // evtSource.addEventListener("ping", function(e) {
  //   var newElement = document.createElement("li");
  //
  //   var obj = JSON.parse(e.data);
  //   newElement.innerHTML = "ping at " + obj.time;
  //   eventList.appendChild(newElement);
  // }, false);
</script>
</body>
</html>
