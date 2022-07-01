<!-- Sidebar -->
<style>
    .sub_icon {
        font-size: 14px !important;
        margin: 0 2px 0 10px !important;
    }
</style>
@isset($ssm)
@php $ssm = $ssm @endphp
@else
@php $ssm = '' @endphp
@endisset
<div class="sidebar">
	<div class="sidebar-background"></div>
	<div class="sidebar-wrapper scrollbar-inner">
		<div class="sidebar-content">
			<ul class="nav">
				<li class="nav-item {{$p=='da'?'active':''}}">
                    <a href="{{ route('admin.dashboard') }}">
						<i class="fas fa-home"></i>
						<p>Dashboard</p>
					</a>
                </li>

				<li class="nav-section">
					<span class="sidebar-mini-icon">
						<i class="fa fa-ellipsis-h"></i>
					</span>
					<h4 class="text-section">Components</h4>
                </li>

                @role('admin')
                <li class="nav-item {{$p=='admin'?'active':''}}">
                    <a data-toggle="collapse" href="#admin">
                        <i class="fas fa-user-shield"></i>
                        <p>Admin</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{$p=='admin'?'show':''}}" id="admin">
                        <ul class="nav nav-collapse">
                            <li class="{{$sm=='adminIndex'?'activeSub':''}}">
                                <a href="{{ route('admin-user.index')}}">
                                    <span class="sub-item">User Management</span>
                                </a>
                            </li>
                            <li class="{{$sm=='empIndex'?'activeSub':''}}">
                                <a href="{{ route('employee.index')}}">
                                    <span class="sub-item">Employee</span>
                                </a>
                            </li>
                            <li class="{{$sm=='companyInfoAdmin'?'activeSub':''}}">
                                <a href="{{ route('admin.companyInfo.adminIndex')}}">
                                    <span class="sub-item">Company Info Das.</span>
                                </a>
                            </li>
                            <li class="{{$sm=='companyInfoFront'?'activeSub':''}}">
                                <a href="{{ route('admin.companyInfo.frontIndex')}}">
                                    <span class="sub-item">Company Info Front.</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endrole

                <li class="nav-item {{$p=='frontend'?'active':''}}">
					<a data-toggle="collapse" href="#submenu2">
						<i class="fas fa-bars"></i>
						<p>For User View</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{$p=='frontend'?'show':''}}" id="submenu2">
						<ul class="nav nav-collapse">
                            <li class="{{$sm=='about'?'activeSub':''}}">
                                <a href="{{ url('admin/about/1/edit') }}">
                                    <i class="fas fa-info-circle sub_icon"></i>
                                    <span class="">About</span>
                                </a>
							</li>

							<li>
								<a data-toggle="collapse" href="#sliderSub">
                                    <i class="far fa-images sub_icon"></i>
									<span class="">Slider</span>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="sliderSub">
									<ul class="nav nav-collapse subnav">
										<li class="{{($sm=='sliderIndex')?'activeSub':''}}">
                                            <a href="{{ route('slider.index')}}">
                                                <span class="sub-item">Show Sliders</span>
                                            </a>
                                        </li>
										<li>
											<li class="{{($sm=='sliderCreate')?'activeSub':''}}">
                                                <a href="{{ route('slider.create')}}">
                                                    <span class="sub-item">Add Slider</span>
                                                </a>
                                            </li>
										</li>
									</ul>
								</div>
                            </li>
						</ul>
					</div>
                </li>

                {{-- Tools --}}
                <li class="nav-item {{$p=='tools'?'active':''}}">
					<a data-toggle="collapse" href="#tools">
						<i class="fas fa-tools"></i>
						<p>Tools</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{$p=='tools'?'show':''}}" id="tools">
						<ul class="nav nav-collapse">
                            {{-- <li class="{{$sm=='balkPurchase'?'activeSub':''}}">
                                <a href="{{route('account-entry.index')}}">
                                    <i class="fas fa-file-invoice-dollar sub_icon"></i>
                                    <p>Account Entry</p>
                                </a>
                            </li> --}}
                            <li class="{{$sm=='packSize'?'activeSub':''}}">
                                <a href="{{route('pack-size.index')}}">
                                    <span class="sub-item">Pack Size</span>
                                </a>
                            </li>
                            <li class="{{$sm=='bankList'?'activeSub':''}}">
                                <a href="{{route('bank-list.index')}}">
                                    <span class="sub-item">Bank List</span>
                                </a>
                            </li>
                            <li class="{{$sm=='empCat'?'activeSub':''}}">
                                <a href="{{route('employee-main-cat.index')}}">
                                    <span class="sub-item">Employee Category</span>
                                </a>
                            </li>
                            <li class="{{$sm=='productCat'?'activeSub':''}}">
                                <a href="{{route('product-category.index')}}">
                                    <span class="sub-item">Product Category</span>
                                </a>
                            </li>
                            <li class="{{$sm=='licenseCat'?'activeSub':''}}">
                                <a href="{{route('license-category.index')}}">
                                    <span class="sub-item">License Category</span>
                                </a>
                            </li>
                            <li class="{{$sm=='productLicense'?'activeSub':''}}">
                                <a href="{{route('product-license.index')}}">
                                    <span class="sub-item">Product License</span>
                                </a>
                            </li>
                            <li class="{{$sm=='userBank'?'activeSub':''}}">
                                <a href="{{route('user-bank-ac.index')}}">
                                    <span class="sub-item">User Bank Accounts</span>
                                </a>
                            </li>
                            <li class="{{$sm=='officeExCat'?'activeSub':''}}">
                                <a href="{{ route('office-expense-cat.index')}}">
                                    <span class="sub-item">Office Expense Category</span>
                                </a>
                            </li>
                            <li class="{{$sm=='officeInCat'?'activeSub':''}}">
                                <a href="{{ route('office-income-cat.index')}}">
                                    <span class="sub-item">Office Income Category</span>
                                </a>
                            </li>
						</ul>
					</div>
                </li>

                <li class="nav-item {{$p=='business'?'active':''}}">
                    <a data-toggle="collapse" href="#user">
                        <i class="fas fa-user-tie"></i>
                        <p>Business Per./Fac.</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{$p=='business'?'show':''}}" id="user">
                        <ul class="nav nav-collapse">
                            <li class="{{$sm=='customer'?'activeSub':''}}">
                                <a href="{{ route('customer.index')}}">
                                    <span class="sub-item">Customer</span>
                                </a>
                            </li>
                            <li class="{{$sm=='supplier'?'activeSub':''}}">
                                <a href="{{ route('supplier.index')}}">
                                    <span class="sub-item">Supplier</span>
                                </a>
                            </li>
                            <li class="{{$sm=='store'?'activeSub':''}}">
                                <a href="{{ route('company-store.index')}}">
                                    <span class="sub-item">Store</span>
                                </a>
                            </li>
                            <li class="{{$sm=='factory'?'activeSub':''}}">
                                <a href="{{ route('company-factory.index')}}">
                                    <span class="sub-item">Factory</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


{{-- ________________________ Office Start ________________________ --}}
                <li class="nav-item {{$p=='account'?'active':''}}">
					<a data-toggle="collapse" href="#office">
						<i class="fas fa-briefcase"></i>
						<p>Office</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{$p=='account'?'show':''}}" id="office">
						<ul class="nav nav-collapse">
							<li>
								<a data-toggle="collapse" href="#accSub">
                                    <i class="fas fa-calculator sub_icon"></i>
									<span>Account</span>
									<span class="caret"></span>
								</a>
								<div class="collapse {{$p=='account'?'show':''}}" id="accSub">
									<ul class="nav nav-collapse subnav">
										<li class="{{$sm=='receved'?'activeSub':''}}">
											<a href="{{ route('account-received.index')}}">
                                                <span class="sub-item">Collection</span>
                                            </a>
										</li>
										<li class="{{$sm=='payment'?'activeSub':''}}">
											<a href="{{ route('account-payment.index')}}">
                                                <span class="sub-item">Payment</span>
                                            </a>
                                        </li>
                                        <li class="{{$sm=='deposit'?'activeSub':''}}">
                                            <a href="{{ route('bankDeposit.dCreate')}}">
                                                <span class="sub-item">Deposit</span>
                                            </a>
                                        </li>
                                        <li class="{{$sm=='withdraw'?'activeSub':''}}">
                                            <a href="{{ route('bankWithdraw.wCreate')}}">
                                                <span class="sub-item">Withdraw</span>
                                            </a>
                                        </li>
										<li class="{{$sm=='officeExp'?'activeSub':''}}">
											<a href="{{ route('office-expense.create')}}">
                                                <span class="sub-item">Expense</span>
                                            </a>
                                        </li>
										<li class="{{$sm=='officeExpRe'?'activeSub':''}}">
											<a href="{{ route('officeExp.selectDate')}}">
                                                <span class="sub-item">Expense Report</span>
                                            </a>
                                        </li>

                                        <li class="{{$sm=='officeIn'?'activeSub':''}}">
											<a href="{{ route('office-income.create')}}">
                                                <span class="sub-item">Income</span>
                                            </a>
                                        </li>
                                        <li class="{{$sm=='officeInRe'?'activeSub':''}}">
											<a href="{{ route('officeIn.selectDate')}}">
                                                <span class="sub-item">Income Report</span>
                                            </a>
                                        </li>
                                        <li class="{{$sm=='cashBook'?'activeSub':''}}">
                                            <a href="{{ route('cashBook.selectDate')}}">
                                                <span class="sub-item">Cash Book</span>
                                            </a>
                                        </li>
                                        <li class="{{$sm=='autherLedger'?'activeSub':''}}">
                                            <a href="{{ route('authorLedgerBook.index')}}">
                                                <span class="sub-item">Author Ledger Book</span>
                                            </a>
                                        </li>
                                        <li class="{{$sm=='mainAc'?'activeSub':''}}">
                                            <a href="{{ route('mainAccount.selectDate')}}">
                                                <span class="sub-item">Main Accounts</span>
                                            </a>
                                        </li>

                                        <li class="{{$sm=='bankStat'?'activeSub':''}}">
                                            <a href="{{ route('bankStatement.selectDate')}}">
                                                <span class="sub-item">Bank Statement</span>
                                            </a>
                                        </li>
									</ul>
								</div>
							</li>
							<li>
								<a data-toggle="collapse" href="#marketingSub">
                                    <i class="fas fa-bullhorn sub_icon"></i>
									<span>Marketing</span>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="marketingSub">
									<ul class="nav nav-collapse subnav">
										<li>
											<a href="#">
												<span class="sub-item">Promotional Activities</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							{{-- <li>
								<a href="#">
									<span class="sub-item">Level 1</span>
								</a>
							</li> --}}
						</ul>
					</div>
				</li>
{{-- ________________________ Office End ________________________ --}}


{{-- ________________________ Factory Start ________________________ --}}
                <li class="nav-item {{$p=='factory'?'active':''}}">
					<a data-toggle="collapse" href="#submenuR">
						<i class="fas fa-industry"></i>
						<p>Factory</p>
						<span class="caret"></span>
                    </a>

					<div class="collapse {{$p=='factory'?'show':''}}" id="submenuR">
						<ul class="nav nav-collapse">
                            <li>
								<a data-toggle="collapse" href="#subRaw">
                                    <i class="fas fa-shopping-cart sub_icon"></i>
									<span>Bulk</span>
									<span class="caret"></span>
								</a>
								<div class="collapse {{$ssm=='bulkShow'?'show':''}}" id="subRaw">
									<ul class="nav nav-collapse subnav">
                                        <li class="{{$sm=='balkName'?'activeSub':''}}">
											<a href="{{ route('raw-material.index')}}">
												<span class="sub-item">Bulk Name</span>
											</a>
										</li>
										<li class="{{$sm=='balkPurchase'?'activeSub':''}}">
											<a href="{{ route('purchase-bulk.index')}}">
												<span class="sub-item">Purchase</span>
											</a>
										</li>
										<li class="{{$sm=='balkSales'?'activeSub':''}}">
											<a href="{{ route('sales-bulk.index')}}">
												<span class="sub-item">Bulk Sales</span>
											</a>
										</li>
										<li class="{{$sm=='bulkStock'?'activeSub':''}}">
											<a href="{{ route('stock.bulk.index')}}">
												<span class="sub-item">Bulk Stock</span>
											</a>
										</li>
										<li class="{{$sm=='balkRepack'?'activeSub':''}}">
											<a href="{{ route('send-to-repack-unit.index')}}">
												<span class="sub-item">Send to Repack Unit</span>
											</a>
										</li>
										<li class="{{$sm=='purchaseLed'?'activeSub':''}}">
											<a href="{{ route('purchaseLedgerBook.index')}}">
												<span class="sub-item">Purchase Ledger Book</span>
											</a>
										</li>
										<li class="{{$sm=='bulkReport'?'activeSub':''}}">
											<a href="{{ route('report.bulk.selectDate')}}">
												<span class="sub-item">Report</span>
											</a>
										</li>
									</ul>
								</div>
                            </li>

                            <li>
								<a data-toggle="collapse" href="#subRp">
                                    <i class="fas fa-parking sub_icon"></i>
									<span>Repack Unit</span>
									<span class="caret"></span>
								</a>
								<div class="collapse {{$ssm=='repackUnitShow'?'show':''}}" id="subRp">
									<ul class="nav nav-collapse subnav">
										<li class="{{$sm=='qaqc'?'activeSub':''}}">
											<a href="{{ route('repackingCheck.showAccpet')}}">
												<span class="sub-item">QA/QC</span>
											</a>
                                        </li>
										<li class="{{$sm=='bulkProduction'?'activeSub':''}}">
											<a href="{{ route('bulkTracking.showInvoice')}}">
												<span class="sub-item">Production</span>
											</a>
                                        </li>
										<li class="{{$sm=='productionReport'?'activeSub':''}}">
											<a href="{{ route('production.selectDate')}}">
												<span class="sub-item">Production Report</span>
											</a>
                                        </li>
										{{-- <li>
											<a href="{{ route('repackStock.index')}}">
												<span class="sub-item">Bulk Stock</span>
											</a>
                                        </li> --}}
                                        {{-- <li>
											<a href="{{ route('repackStock.index')}}">
												<span class="sub-item">Update Product Stock</span>
											</a>
										</li> --}}
										{{-- <li class="{{$sm=='sendToPro'?'activeSub':''}}">
											<a href="{{ route('send-to-production.index')}}">
												<span class="sub-item">Send to Store</span>
											</a>
										</li> --}}
									</ul>
								</div>
                            </li>

                            <li>
								<a data-toggle="collapse" href="#subFac">
                                    <i class="fab fa-product-hunt sub_icon"></i>
									<span>Store</span>
									<span class="caret"></span>
								</a>
								<div class="collapse {{$ssm=='storeShow'?'show':''}}" id="subFac">
									<ul class="nav nav-collapse subnav">
                                        <li class="{{$sm=='product'?'activeSub':''}}">
											<a href="{{ route('product.index')}}">
												<span class="sub-item">Product</span>
											</a>
										</li>
										<li class="{{$sm=='storeQaqc'?'activeSub':''}}">
											<a href="{{ route('productionCheck.showAccpet')}}">
												<span class="sub-item">QA/QC</span>
											</a>
										</li>
										<li class="{{$sm=='storeStock'?'activeSub':''}}">
											<a href="{{ route('stock.store.index')}}">
												<span class="sub-item">Stock</span>
											</a>
										</li>
									</ul>
								</div>
                            </li>

                            <li>
								<a data-toggle="collapse" href="#subEqu">
                                    <i class="fas fa-toolbox sub_icon"></i>
									<span>Packaging</span>
									<span class="caret"></span>
								</a>
								<div class="collapse {{$ssm=='packaging'?'show':''}}" id="subEqu">
									<ul class="nav nav-collapse subnav">
										<li class="{{$sm=='labelPurchase'?'activeSub':''}}">
											<a href="{{ route('label-purchase.index')}}">
												<span class="sub-item">Label Purchase</span>
											</a>
										</li>
										<li class="{{$sm=='labelSentR'?'activeSub':''}}">
											<a href="{{ route('label-send-to-repack-unit.index')}}">
												<span class="sub-item">Send to Repack Unit</span>
											</a>
										</li>
										<li class="{{$sm=='labelStock'?'activeSub':''}}">
											<a href="{{ route('labelStock.index')}}">
												<span class="sub-item">Label Stock</span>
											</a>
										</li>
									</ul>
								</div>
                            </li>
						</ul>
					</div>
                </li>
{{-- ________________________ Factory End ________________________ --}}


{{-- ________________________ Sales Start ________________________ --}}
                <li class="nav-item {{$p=='sales'?'active':''}}">
                    <a data-toggle="collapse" href="#invoice">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>Sales</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{$p=='sales'?'show':''}}" id="invoice">
                        <ul class="nav nav-collapse">
                            <li class="{{$sm=='sample'?'activeSub':''}}">
                                <a href="{{ route('sample-invoive.index')}}">
                                    <span class="sub-item">Sample</span>
                                </a>
                            </li>
                            <li class="{{$sm=='salesCash'?'activeSub':''}}">
                                <a href="{{ route('sales-invoice-cash.index')}}">
                                    <span class="sub-item">Sales</span>
                                </a>
                            </li>
                            <li class="{{$sm=='salesCashRe'?'activeSub':''}}">
                                <a href="{{ route('sales-invoice-cash-return.index')}}">
                                    <span class="sub-item">Sales Return</span>
                                </a>
                            </li>
                            <li class="{{$sm=='salesLedger'?'activeSub':''}}">
                                <a href="{{ route('salesLedgerBook.index')}}">
                                    <span class="sub-item">Ledger Book</span>
                                </a>
                            </li>
                            <li class="{{$sm=='salesReport'?'activeSub':''}}">
                                <a href="{{ route('report.salesAndStock.selectDate')}}">
                                    <span class="sub-item">Report</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{$p=='report'?'active':''}}">
                    <a data-toggle="collapse" href="#report">
                        <i class="fas fa-file"></i>
                        <p>Report</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{$p=='report'?'show':''}}" id="report">
                        <ul class="nav nav-collapse">
                            <li class="{{$sm=='cashBook'?'activeSub':''}}">
                                <a href="{{ route('cashBook.selectDate')}}">
                                    <span class="sub-item">Cash Book</span>
                                </a>
                            </li>
                            <li class="{{$sm=='bankStat'?'activeSub':''}}">
                                <a href="{{ route('bankStatement.selectDate')}}">
                                    <span class="sub-item">Bank Statement</span>
                                </a>
                            </li>
                            <li class="{{$sm=='officeExpRe'?'activeSub':''}}">
                                <a href="{{ route('officeExp.selectDate')}}">
                                    <span class="sub-item">Head Office Exp. Rep.</span>
                                </a>
                            </li>
                            <li class="{{$sm=='empReport'?'active':''}}">
                                <a href="{{ route('empReport.user') }}">
                                    <span class="sub-item">Employee Report</span>
                                </a>
                            </li>
                            <li class="{{$sm=='customerReport'?'activeSub':''}}">
                                <a href="{{ route('customer-report.index') }}">
                                    <span class="sub-item">Customer Report</span>
                                </a>
                            </li>
                            {{-- <li class="{{$sm=='storeStock'?'activeSub':''}}">
                                <a href="{{ route('stock.store.index')}}">
                                    <span class="sub-item">Store Stock</span>
                                </a>
                            </li>
                            <li class="{{$sm=='totalStock'?'activeSub':''}}">
                                <a href="{{ route('totalStock.selectDate')}}">
                                    <span class="sub-item">Total Stock</span>
                                </a>
                            </li> --}}
                            <li class="{{$sm=='salesAndStock'?'activeSub':''}}">
                                <a href="{{ route('report.salesAndStock.selectDate')}}">
                                    <span class="sub-item">Sales Report</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Trash start --}}
                <li class="nav-item {{$p=='trash'?'active':''}}">
                    <a data-toggle="collapse" href="#trash">
                        <i class="fas fa-trash"></i>
                        <p>Trash</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{$p=='trash'?'show':''}}" id="trash">
                        <ul class="nav nav-collapse">
                            <li class="{{$sm=='rReceived'?'activeSub':''}}">
                                <a href="{{ route('received.trash')}}">
                                    <span class="sub-item">Collection</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Trash end --}}

                <li class="nav-item {{$p=='backup'?'active':''}}">
                    <a class="dropdown-item" href="{{ route('admin.backup.password') }}" >
                        <i class="fas fa-database"></i>
                        <p>App Backup</p>
                    </a>
                </li>

                <li class="nav-item {{$p=='visitor'?'active':''}}">
                    <a class="dropdown-item" href="{{ route('admin.visitorInfo.index') }}" >
                        <i class="fas fa-user-secret"></i>
                        <p>Visitor Info</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

                {{-- <li class="nav-item {{$p=='customer'?'active':''}}">
                    <a data-toggle="collapse" href="#customer">
                        <i class="fas fa-users"></i>
                        <p>Customer</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="customer">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('customer.index')}}">
                                    <span class="sub-item">Show Customer</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.create')}}">
                                    <span class="sub-item">Add Customer</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}


                {{-- <li class="nav-item {{$p=='invoice'?'active':''}}">
                    <a href="{{ route('invoice.index')}}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>Invoice</p>
                    </a>
                </li> --}}

				{{-- <li class="nav-item">
					<a data-toggle="collapse" href="#submenu">
						<i class="fas fa-bars"></i>
						<p>Menu Levels</p>
						<span class="caret"></span>
					</a>
					<div class="collapse" id="submenu">
						<ul class="nav nav-collapse">
							<li>
								<a data-toggle="collapse" href="#subnav1">
									<span class="sub-item">Level 1</span>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="subnav1">
									<ul class="nav nav-collapse subnav">
										<li>
											<a href="#">
												<span class="sub-item">Level 2</span>
											</a>
										</li>
										<li>
											<a href="#">
												<span class="sub-item">Level 2</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a data-toggle="collapse" href="#subnav2">
									<span class="sub-item">Level 1</span>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="subnav2">
									<ul class="nav nav-collapse subnav">
										<li>
											<a href="#">
												<span class="sub-item">Level 2</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a href="#">
									<span class="sub-item">Level 1</span>
								</a>
							</li>
						</ul>
					</div>
				</li> --}}
			</ul>
		</div>
	</div>
</div>
<!-- End Sidebar -->






