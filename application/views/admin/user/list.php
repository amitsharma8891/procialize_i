<div class="contentpanel"><!-- Content Panel -->

    <div class="row mb10"><!-- Add Exhibitor Row -->
    	
    	<div class="row mb10"><!-- Add Exhibitor Row -->
				
				<div class="col-sm-12 col-md-12">
				<ul class="filemanager-options">
					<li>
					  <div class="ckbox ckbox-default">
						<input type="checkbox" id="selectall" value="1" />
						<label for="selectall">Select All</label>
					  </div>
					</li>
					<li>
					  <a href="#" class="itemopt disabled"><i class="fa fa-refresh"></i> Refresh</a>
					</li>
					<li>
					  <a href="#" class="itemopt disabled"><i class="fa fa-trash-o"></i> Delete</a>
					</li>
					
					<li>
						<div class="ckbox ckbox-default">
							<input type="text" placeholder="Search" class="form-control">
						</div>
					</li>
					<li>
					  <div class="ckbox ckbox-default">
						<select type="select" class="form-control">
							<option value="selected">A to Z</option>
							<option value="A">Featured First</option>
							<option value="B">Locality</option>
						</select>
					  </div>
					</li>
				</ul>	
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="table-responsive">
					  <table class="table mb30">
						<tbody>
							<?php
							if(empty($list)) { ?>
								 <tr>
							<td class="text-center">No Users found</td>
							<?php } else {
							 foreach($list as $user) { ?>
						  <tr>
							<td class="text-center"><input type="checkbox"></td>
							<td><i class="fa fa-shield"></i></td>
							<td><img src="images/logogo.png" width="20px" height="20px" title="Exhibitor's Logo" alt=""></td>  
							<td><?php echo $user->first_name.' '.$user->last_name; ?></td>
							<td class="table-action">
                                                            
							  <a href="#"><i class="fa fa-bar-chart-o"></i></a>
							  <a href="<?php echo base_url().'manage/user/edit/'.$user->id; ?>"><i class="fa fa-pencil"></i></a>
							  <a href="#" class="delete-row"><i class="fa fa-trash-o"></i></a>
							</td>
						  </tr>

						  <?php  } 

						  	}
						  ?>
						  
						</tbody>
					  </table>
					  </div><!-- table-responsive -->
				</div>
			</div>
		
		</div><!-- contentpanel -->

    </div>


</div>