/**
 * Records controller.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

Editor.Controllers.Records = (function(Backbone, Editor) {

  var Records = {};


  /*
   * Instantiate the records view, fetch records.
   *
   * @return void.
   */
  Records.init = function() {

    // Construct view.
    Records.Records = new Editor.Views.Records({ el: '#records' });

    // Get records.
    this.records = new Editor.Collections.Records();
    this.fetch();

  };

  /*
   * Query for records.
   *
   * @param {Object} params: Query parameters.
   *
   * @return void.
   */
  Records.fetch = function(params) {

    params = params || {};

    // Get records.
    this.records.fetch({
      data: $.param(params),
      success: function(records) {
        Records.Records.ingest(records);
      }
    });

  };


  // Export.
  Editor.addInitializer(function() { Records.init(); });
  return Records;

})(Backbone, Editor);
