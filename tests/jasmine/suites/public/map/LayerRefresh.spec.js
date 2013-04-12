
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * Tests for map layer refresh.
 *
 * @package     omeka
 * @subpackage  neatline
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

describe('Map Layer Refresh', function() {


  beforeEach(function() {
    _t.loadNeatline();
  });


  it('should clear and rebuild all layers', function() {

    // --------------------------------------------------------------------
    // The `MAP:refresh` command should completely wipe out all existing
    // layers and reload records for the current viewport focus.
    // --------------------------------------------------------------------

    // Load default layers.
    _t.refreshMap(_t.json.MapLayerRefresh.records.regular);
    var layers = _t.vw.MAP.getVectorLayers();

    // Should manifest original data.
    expect(layers[0].features[0].geometry.x).toEqual(1);
    expect(layers[0].features[0].geometry.y).toEqual(2);
    expect(layers[1].features[0].geometry.x).toEqual(3);
    expect(layers[1].features[0].geometry.y).toEqual(4);
    expect(layers[2].features[0].geometry.x).toEqual(5);
    expect(layers[2].features[0].geometry.y).toEqual(6);
    _t.assertVectorLayerCount(3);

    Neatline.execute('MAP:refresh');

    // Respond with changed coverage data.
    _t.respondLast200(_t.json.MapLayerRefresh.records.changed);
    var layers = _t.vw.MAP.getVectorLayers();

    // Should manifest changed data.
    expect(layers[0].features[0].geometry.x).toEqual(7);
    expect(layers[0].features[0].geometry.y).toEqual(8);
    expect(layers[1].features[0].geometry.x).toEqual(9);
    expect(layers[1].features[0].geometry.y).toEqual(10);
    expect(layers[2].features[0].geometry.x).toEqual(11);
    expect(layers[2].features[0].geometry.y).toEqual(12);
    _t.assertVectorLayerCount(3);

  });


  it('should not rebuild frozen layers', function() {

    // --------------------------------------------------------------------
    // `MAP:refresh` should exclude frozen vector layers from refresh.
    // --------------------------------------------------------------------

    // Load default layers, freeze layer 2.
    _t.refreshMap(_t.json.MapLayerRefresh.records.regular);
    _t.getVectorLayerByTitle('title2').nFrozen = true;

    Neatline.execute('MAP:refresh');

    // Respond with changed coverage data.
    _t.respondLast200(_t.json.MapLayerRefresh.records.changed);
    var layer = _t.getVectorLayerByTitle('title2');

    // Should not change layer 2 geometry.
    expect(layer.features[0].geometry.x).toEqual(3);
    expect(layer.features[0].geometry.y).toEqual(4);

  });


});