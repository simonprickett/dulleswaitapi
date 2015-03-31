window.onload = function() {
	$.ajax({
		url: "http://dulleswaitapi.crudworks.org/",
		success: function( data ) {
			var dullesData = data.airports[0],
				numCheckPoints = data.airports[0].checkPoints.length,
				eastWait = -1,
				westWait = -1,
				updatedAt = -1,
				n = 0,
				thisCheckPoint = undefined;

			updatedAt = dullesData.lastUpdatedTimestamp;
			for (n = 0; n < numCheckPoints; n++) {
				thisCheckPoint = dullesData.checkPoints[n];
				if (thisCheckPoint.name === 'East') {
					console.log('East: ' + thisCheckPoint.wait);
					$('#eastwaittime').html(thisCheckPoint.wait);
				} else {
					console.log('West: ' + thisCheckPoint.wait);
					$('#westwaittime').html(thisCheckPoint.wait);
				}
			}
			console.log(updatedAt);
		}
	});
}