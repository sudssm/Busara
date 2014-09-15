// rudimentary measure to prevent accidental use online
if (window.location.href.indexOf('localhost') < 0) {
  window.location = 'http://localhost/no_online.html'
}

function makeId (){
  return Math.floor(Math.random()*900000) + 100000;
}

function timeToDB(time){
  time = time.split(' ')
  time[0] = time[0].split('-')
  time = time[0][2] + '-' + time[0][1] + '-' + time[0][0] + ' ' + time[1]
  return time
}

function doQuery (query, callback){
  $.post( "http://localhost/query.php", 
    {query: query},
    function( data ) {
      try {
        data = JSON.parse(data)
      }
      catch(err){
        console.log(err);
        console.log(data);
      }
      callback(data);
    }
  );
}
function doUpdate (query, callback){
  $.post( "http://localhost/update.php", 
    {query: query}, callback
  );
}

function getDemographics (callback){
  doQuery("SELECT * FROM demographic", function(data){
    dict = {}
    $.each(data, function(i, x){dict[x.id] = x})
    callback(dict);
  })
}

function getProjects (callback){
  doQuery("SELECT * FROM project", function(data){
    dict = {}
    $.each(data, function(i, x){dict[x.id] = x})
    callback(dict);
  })
}

function getSessions (projectId, callback){
  doQuery("SELECT * FROM session where project_id = " + projectId, function(data){
    dict = {}
    $.each(data, function(i, x){dict[x.id] = x})
    callback(dict);
  })
}

function getSurveysBySession (sessionId, callback){
  query = "SELECT survey.id as survey_id, first_name, last_name, invited, participated, pay FROM participation, survey WHERE survey_id = survey.id and session_id = " + sessionId
  doQuery(query, callback)
}

function getSurveys (callback){
  doQuery("SELECT * from survey", function(data){
    data = $.map(data, function(x){return x.id})
    callback(data);
  })
}