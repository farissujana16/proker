<?= $this->extend('base_view'); ?>

<?= $this->section('content'); ?>


<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-12 col-md-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-0">Menu Groups Access</h5>
                            </div>
                            <!-- <div class="dropdown options ms-auto">
                                <button type="button" onclick="ViewData(0)" class="btn btn-primary"><i class="bx bx-plus mr-1"></i>Tambah</button>
                            </div> -->
                        </div>
                        <hr>
                        <div class="table-responsive">
							<table id="menu_groups_accessTable" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<!-- <th width='5%'>Action</th> -->
										<th>#</th>
										<th>Menu Groups</th>
										<th></th>
										<!-- <th>Active</th> -->
									</tr>
								</thead>
								<tbody></tbody>
								
							</table>
						</div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->
    </div>
</div>



<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
    console.log(<?= $id_level ?>);
    var menu_groups_accessTable = $('#menu_groups_accessTable').DataTable({
            "ordering": false,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            // oLanguage: {sProcessing: $('.loader').hide()},
            ajax: {
                url: "<?= base_url() ?>level/ax_data_menu_groups_access",
                type: 'POST',
                data: function(d) {
                    return $.extend({}, d, {
                        "id_level": <?= $id_level ?>,
                    });
                }
            },
            columns: [
                // {
                //     data: "id_menu_details",
                //     render: function(data, type, full, meta){
                    //         var str = '';
                    //         str += '<div class="dropdown">'
                    // 		str += '<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Action</button>'
                    // 		str += '<ul class="dropdown-menu" style="">'
                    // 		str += '<li><a class="dropdown-item" onclick="ViewData('+data+')"><i class="bx bx-edit-alt"></i> Edit</a></li>'
                    // 		str += '<li><a class="dropdown-item" onclick="DeleteData('+data+')"><i class="bx bx-trash"></i> Delete</a></li>'
                    // 		str += '</ul>'
                    // 		str += '</div>'
                    
                    //         return str;
                    //     } 
                    // },
                    {data: "id_menu_groups"},
                    {data: "nm_menu_groups"},
                    {
                        data: "active",
                        render: function(data, type, full, meta){
                            str = '';
                            if (data == 0) {
                                str += '';
                            }else if (data == 1){
                                str += 'checked';
                            }
                            return '<input class="form-check-input me-1" type="checkbox" value="" '+str+' onclick="simpanGroup('+full.id_menu_groups+','+full.id_menu_groups_access+','+data+')"id="group_'+full.id_menu_groups+'">'
                    }
                },
                // {
                //     data: "active",
                //     render: function(data, type, full, meta){
                //         var str;
                //         if(data == 1){
                //             str = '<span class="badge bg-success rounded-pill">Active</span>'
                //         }else{
                //             str = '<span class="badge bg-danger rounded-pill">Active</span>'
                //         }
                //         return str;
                //     }
                // },
            ]
    });

    function simpanGroup(id_menu_groups, id_menu_groups_access, active){
      // alert(id_menu_group);

      if ($('#group_'+id_menu_groups).is(":checked")) {
        var url = "<?= base_url() ?>level/ax_set_group_access";
        var data = {
          id_menu_groups: id_menu_groups,
          id_menu_groups_access: id_menu_groups_access,
          active: active,
          id_level: <?= $id_level ?>
        };

        $.ajax({
          url: url,
          method: 'POST',
          data: data
        }).done(function(data, textStatus, jqXHR) {
          var data = JSON.parse(data);
          menu_groups_accessTable.ajax.reload();
        //   if (data['status'] == "success") {
        //     Swal.fire({
        //       icon: "success",
        //       title: "Saved!",
        //       text: "Your file has been saved.",
        //       customClass: { confirmButton: "btn btn-success" },
        //     });
        //   }
        });
      }else{
        var url = "<?= base_url() ?>level/ax_unset_group_access";
        var data = {
            id_menu_groups: id_menu_groups,
            id_menu_groups_access: id_menu_groups_access,
            active: active,
            id_level: <?= $id_level ?>
        };

        $.ajax({
          url: url,
          method: 'POST',
          data: data
        }).done(function(data, textStatus, jqXHR) {
          var data = JSON.parse(data);
          menu_groups_accessTable.ajax.reload();
        //   if (data['status'] == "success") {
        //     Swal.fire({
        //       icon: "success",
        //       title: "Deleted!",
        //       text: "Your file has been deleted.",
        //       customClass: { confirmButton: "btn btn-success" },
        //     });
        //   }
        });

      }
    }
</script>

<?= $this->endSection() ?>
