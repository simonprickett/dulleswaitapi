var myApp = {
	updateWaitTime: function() {
		$('#eastwaittime').html('?');
		$('#westwaittime').html('?');
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

				for (n = 0; n < numCheckPoints; n++) {
					thisCheckPoint = dullesData.checkPoints[n];
					if (thisCheckPoint.name === 'East') {
						$('#eastwaittime').html(thisCheckPoint.wait);
					} else {
						$('#westwaittime').html(thisCheckPoint.wait);
					}
				}
			}
		});
	}
};

window.onload = function() {
	myApp.updateWaitTime();
	window.setInterval(myApp.updateWaitTime, 120000);
}