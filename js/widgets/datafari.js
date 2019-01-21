/** global: OCA */
/** global: OC */
/** global: net */


(function () {

	/**
	 * @constructs Datafari
	 */
	var Datafari = function () {

		var datafari = {

			init: function () {
                $('#btn-datafari-search').on('click', function(e){
                    datafari.search()
                });
            },
            
            search: function() {
                let term = $('#input-datafari').val();
                let baseUrl = OC.generateUrl('/apps/datafari/');
                window.location.href = baseUrl + "?search=" + term;

            },

		};

		$.extend(Datafari.prototype, datafari);
	};

	OCA.DashBoard.Datafari = Datafari;
	OCA.DashBoard.datafari = new Datafari();

})();