		function routeRow(route){
		routeRow = '<tr id="routeRow'+route.id+'">';
		routeRow += '<td>'+route.uri+'</td>';
		routeRow += '<td>'+route.title+'</td>';
		routeRow += '<td>'+route.handlerName+'</td>';
		routeRow += '<td>'+route.authorisation+'</td>';
		routeRow += '<td style="width:30px;"><a class="btn btn-mini ';
		if (route.authorisation== "readonly"){
			routeRow += 'disabled';
		} else {
			routeRow += 'btn-primary editRoute';
		}
		routeRow += '" data-route-id= "'+route.id+'" >Edit</a>'
		routeRow += '<a class="btn btn-mini ';
		if (route.authorisation== "readonly"){
			routeRow += 'disabled';
		} else {
			routeRow += 'btn-danger deleteRoute';
		}
		routeRow += '" data-route-id= "'+route.id+'" style="margin-left:11px;">Delete</a></td>';
		routeRow += '</tr>';
		return routeRow.replace("null","");
	}
	
	$(function(){
	
		$("#routeContent").on("click",".editRoute",function(){
			var id = $(this).attr("data-route-id");
			data  = { "id": id}
			$.ajax(
				window.baseURL+"api/route/",
				{
					"type": "GET",
					"data": data
				}
			).done(function(data){
					$("#changeType").text("Edit");
					$("#edit_id").val(data.id);
					$("#edit_uri").val(data.uri);
					$("#edit_title").val(data.title);
					$("#edit_description").val(data.description);
					$("#edit_keywords").val(data.keywords.join(","));
					$("#edit_handlerName").val(data.handlerName);
					$("#edit_authorisation").val(data.authorisation);
					$("#edit_modal").modal("show");
			})
		

		})
	
		$(".newRoute").on("click",function(){
			$("#changeType").text("New");
			$("#edit_id").val("");
			$("#edit_uri").val("");
			$("#edit_title").val("");
			$("#edit_description").val("");
			$("#edit_keywords").val("");
			$("#edit_handlerName").val("");
			$("#edit_authorisation").val("");
			$("#edit_modal").modal("show");
		
		});
	
	
		$(".saveRoute").on("click",function(){
			var id = $("#edit_id").val();
		
			var data =	{
						"uri":				$("#edit_uri").val(),
						"title":			$("#edit_title").val(),
						"description":		$("#edit_description").val(),
						"keywords":			$("#edit_keywords").val(),
						"handlerName":		$("#edit_handlerName").val(),
						"authorisation":	$("#edit_authorisation").val()
					}
			if (id!=""){
				data.id = id;
			}
			
			$.ajax(
				window.baseURL+"api/route/",
				{
					"type": "POST",
					"data": data
				}
			).done(function(data){
					$("#edit_id").val("");
					$("#edit_uri").val("");
					$("#edit_title").val("");
					$("#edit_description").val("");
					$("#edit_keywords").val("");
					$("#edit_handlerName").val("");
					$("#edit_authorisation").val("");
					$("#edit_modal").modal("hide");
					if ($('#routeRow'+data.id).length>0){
						$('#routeRow'+data.id).replaceWith(routeRow(data));
					} else {
						console.log("response:",data);
						$("#routeContent").append(routeRow(data));
					}
			})
		

		})
	});