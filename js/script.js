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
  console.log(query);
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
  console.log(query)
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
  query = "SELECT DISTINCT survey.id as survey_id, first_name, last_name, invited, participated, identified, pay, cellphone FROM participation, survey WHERE survey_id = survey.id and session_id = " + sessionId
  doQuery(query, function(data){
    count = 0;
    if(data.length == 0)
      callback(data)
    $.each (data, function (i, s){
      count += 1;
      getSurveyInfo(s.survey_id, function(dems){
        count -= 1;
        s["dems"]={}
        $.each(dems, function(i, d){
          if (d.name in s)
            s.dems[d.name].push(d);
          else
            s.dems[d.name] = [d]
        })
        if (count == 0)
          callback(data);
      })
    })
  })
}

function getSurveyInfo (surveyId, callback){
  query = "SELECT demographic.id, demographic.name as name, value, timestamp FROM demographic, demographic_values WHERE demographic.id = demographic_id AND survey_id = " + surveyId + " ORDER BY TIMESTAMP"
  doQuery(query, callback);
}

function getSurveys (callback){
  doQuery("SELECT * from survey", function(data){
    data = $.map(data, function(x){return x.id})
    callback(data);
  })
}

function setParticipationProperty(survey_id, session_id, property, value){
  doUpdate("UPDATE participation SET " + property + "=" + value + " WHERE survey_id=" + survey_id + " AND session_id=" + session_id)
}

function setSurveyProperty(survey_id, property, value){
  doUpdate("UPDATE survey SET " + property + "='" + value + "' WHERE id=" + survey_id)
}

function addDem (survey_id, demographic_id, value){
  doUpdate("INSERT INTO demographic_values (survey_id, demographic_id, value) VALUES (" + survey_id + "," + demographic_id + ",'" + value + "')")
}