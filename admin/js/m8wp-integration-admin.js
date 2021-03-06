(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).ready(function() {
	    $(".js-example-data-ajax").select2({
	      //element configuration
	      width: '100%',



	      //ajax call
		  ajax: {
		    url: "https://api.github.com/search/repositories",
		    dataType: 'json',
		    delay: 250,
		    data: function (params) {
		      return {
		        q: params.term, // search term
		        page: params.page
		      };
		    },
		    processResults: function (data, params) {
		      // parse the results into the format expected by Select2
		      // since we are using custom formatting functions we do not need to
		      // alter the remote JSON data, except to indicate that infinite
		      // scrolling can be used
		      params.page = params.page || 1;

		      return {
		        results: data.items,
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
		      };
		    },
		    cache: true
		  },
		  placeholder: 'Search for a repository',
		  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
		  minimumInputLength: 1,
		  templateResult: formatRepo,
		  templateSelection: formatRepoSelection
		});

		function formatRepo (repo) {
		  if (repo.loading) {
		    return repo.text;
		  }

		  var markup = "<div class='select2-result-repository clearfix'>" +
		    // "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
		    "<div class='select2-result-repository__meta'>" +
		      "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

		  if (repo.description) {
		    markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
		  }

		  markup += 
		  // "<div class='select2-result-repository__statistics'>" +
		  //   "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
		  //   "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
		  //   "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
		  // "</div>" +
		  "</div></div>";

		  return markup;
		}

		function formatRepoSelection (repo) {
		  return repo.full_name || repo.text;
		}
	});

})( jQuery );
