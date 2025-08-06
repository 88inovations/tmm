<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="unitConversionModal" tabindex="-1" role="dialog" aria-labelledby="unitConversionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title ">Item Name: <span class="unitConversionItem" id="unitConversionModalLabel"></span></h3>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Base Unit: <span class="baseUnitName"></span></h4>

        <div >
          <table class="table">
            <thead>
              <tr>
                <th>Conversion Qty</th>
                <th>Base Unit</th>
                <th>Unit</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="unitConversionArea">
              
                
              
            </tbody>
            <tfoot>
              <tr>
                <td><button type="button" class="btn btn-sm btn-info addNewRow">+</button></td>
                <td colspan="4"></td>
                <!-- <button type="button" class="btn btn-sm btn-danger unitRemoveButton">X</button> -->
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary unitConversionSave">Save changes</button>
      </div>
    </div>
  </div>
</div>