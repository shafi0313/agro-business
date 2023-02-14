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

@isset($p)
    @php $p = $p @endphp
@else
    @php $p = '' @endphp
@endisset

@isset($sm)
    @php $sm = $sm @endphp
@else
    @php $sm = '' @endphp
@endisset

<div class="sidebar">
    <div class="sidebar-background"></div>
    <div class="sidebar-wrapper scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav">
                <li class="nav-item {{ $p == 'da' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>@lang('nav.dashboard')</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">@lang('nav.component')</h4>
                </li>

                <li class="nav-item {{ activeNav(['admin-user.*', 'employee.*']) }}">
                    <a data-toggle="collapse" href="#admin">
                        <i class="fas fa-user-shield"></i>
                        <p>@lang('nav.admin')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ openNav(['admin-user.*', 'employee.*']) }}" id="admin">
                        <ul class="nav nav-collapse">
                            @can('user-manage')
                                <li class="{{ activeSubNav('admin-user.*') }}">
                                    <a href="{{ route('admin-user.index') }}">
                                        <span class="sub-item">User Management</span>
                                    </a>
                                </li>
                            @endcan
                            @can('employee-manage')
                                <li class="{{ activeSubNav('employee.*') }}">
                                    <a href="{{ route('employee.index') }}">
                                        <span class="sub-item">Employee</span>
                                    </a>
                                </li>
                            @endcan
                            {{-- <li class="{{ $sm == 'companyInfoAdmin' ? 'activeSub' : '' }}">
                                <a href="{{ route('admin.companyInfo.adminIndex') }}">
                                    <span class="sub-item">Company Info Das.</span>
                                </a>
                            </li>
                            <li class="{{ $sm == 'companyInfoFront' ? 'activeSub' : '' }}">
                                <a href="{{ route('admin.companyInfo.frontIndex') }}">
                                    <span class="sub-item">Company Info Front.</span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>

                @can('about-edit', 'slider-manage')
                    <li class="nav-item {{ activeNav(['about.*', 'slider.*']) }}">
                        <a data-toggle="collapse" href="#forUserView">
                            <i class="fas fa-bars"></i>
                            <p>@lang('nav.frontend')</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ openNav(['about.*', 'slider.*']) }}" id="forUserView">
                            <ul class="nav nav-collapse">
                                @can('about-edit')
                                    <li class="{{ activeSubNav('about.*') }}">
                                        <a href="{{ route('about.edit', 1) }}">
                                            <span class="sub-item">About</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('slider-manage')
                                    <li class="{{ activeSubNav('slider.*') }}">
                                        <a href="{{ route('slider.index') }}">
                                            <span class="sub-item">Slider</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                {{-- Product Start --}}
                <li
                    class="nav-item {{ openNav(['product-category.*', 'pack-size.*', 'product.*', 'raw-material.*']) }}">
                    <a data-toggle="collapse" href="#onlyProduct">
                        <i class="fa-brands fa-product-hunt"></i>
                        <p>@lang('nav.product')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ openNav(['product-category.*', 'pack-size.*', 'product.*', 'raw-material.*']) }}"
                        id="onlyProduct">
                        <ul class="nav nav-collapse ">
                            <li class="{{ activeSubNav('product-category.*') }}">
                                <a href="{{ route('product-category.index') }}">
                                    <span class="sub-item">Product Category</span>
                                </a>
                            </li>
                            <li class="{{ activeSubNav('pack-size.*') }}">
                                <a href="{{ route('pack-size.index') }}">
                                    <span class="sub-item">Pack Size</span>
                                </a>
                            </li>
                            <li class="{{ activeSubNav('product.*') }}">
                                <a href="{{ route('product.index') }}">
                                    <span class="sub-item">Product</span>
                                </a>
                            </li>
                            <li class="{{ activeSubNav('raw-material.*') }}">
                                <a href="{{ route('raw-material.index') }}">
                                    <span class="sub-item">Bulk Product</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Product End --}}

                {{-- Tools --}}
                <li
                    class="nav-item {{ activeNav(['pack-size.*', 'bank-list.*', 'employee-main-cat.*', 'product-category.*', 'license-category.*', 'product-license.*', 'user-bank-ac.*', 'office-expense-cat.*', 'office-income-cat.*']) }}">
                    <a data-toggle="collapse" href="#tools">
                        <i class="fas fa-tools"></i>
                        <p>@lang('nav.tools')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ openNav(['pack-size.*', 'bank-list.*', 'employee-main-cat.*', 'product-category.*', 'license-category.*', 'product-license.*', 'user-bank-ac.*', 'office-expense-cat.*', 'office-income-cat.*']) }}"
                        id="tools">
                        <ul class="nav nav-collapse">
                            {{-- <li class="{{$sm=='balkPurchase'?'activeSub':''}}">
                                <a href="{{route('account-entry.index')}}">
                                    <i class="fas fa-file-invoice-dollar sub_icon"></i>
                                    <p>Account Entry</p>
                                </a>
                            </li> --}}
                            @can('pack-size-manage')
                                <li class="{{ activeSubNav('pack-size.*') }}">
                                    <a href="{{ route('pack-size.index') }}">
                                        <span class="sub-item">Pack Size</span>
                                    </a>
                                </li>
                            @endcan
                            @can('bank-list-manage')
                                <li class="{{ activeSubNav('bank-list.*') }}">
                                    <a href="{{ route('bank-list.index') }}">
                                        <span class="sub-item">Bank List</span>
                                    </a>
                                </li>
                            @endcan
                            @can('employee-category-manage')
                                <li class="{{ activeSubNav('employee-main-cat.*') }}">
                                    <a href="{{ route('employee-main-cat.index') }}">
                                        <span class="sub-item">Employee Category</span>
                                    </a>
                                </li>
                            @endcan

                            @can('product-category-manage')
                                <li class="{{ activeSubNav('product-category.*') }}">
                                    <a href="{{ route('product-category.index') }}">
                                        <span class="sub-item">Product Category</span>
                                    </a>
                                </li>
                            @endcan

                            @can('license-category-manage')
                                <li class="{{ activeSubNav('license-category.*') }}">
                                    <a href="{{ route('license-category.index') }}">
                                        <span class="sub-item">License Category</span>
                                    </a>
                                </li>
                            @endcan
                            @can('product-license-manage')
                                <li class="{{ activeSubNav('product-license.*') }}">
                                    <a href="{{ route('product-license.index') }}">
                                        <span class="sub-item">Product License</span>
                                    </a>
                                </li>
                            @endcan
                            @can('user-bank-accounts-manage')
                                <li class="{{ activeSubNav('user-bank-ac.*') }}">
                                    <a href="{{ route('user-bank-ac.index') }}">
                                        <span class="sub-item">User Bank Accounts</span>
                                    </a>
                                </li>
                            @endcan
                            @can('office-expense-category-manage')
                                <li class="{{ activeSubNav('office-expense-cat.*') }}">
                                    <a href="{{ route('office-expense-cat.index') }}">
                                        <span class="sub-item">Office Expense Category</span>
                                    </a>
                                </li>
                            @endcan
                            @can('office-income-category-manage')
                                <li class="{{ activeSubNav('office-income-cat.*') }}">
                                    <a href="{{ route('office-income-cat.index') }}">
                                        <span class="sub-item">Office Income Category</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>

                @can('customer-manage', 'supplier-manage', 'store-manage', 'factory-manage')
                    <li
                        class="nav-item {{ activeNav(['customer.*', 'supplier.*', 'company-store.*', 'company-factory.*']) }}">
                        <a data-toggle="collapse" href="#businessPerson">
                            <i class="fas fa-user-tie"></i>
                            <p>Business Per./Fac.</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ openNav(['customer.*', 'supplier.*', 'company-store.*', 'company-factory.*']) }}"
                            id="businessPerson">
                            <ul class="nav nav-collapse">
                                @can('customer-manage')
                                    <li class="{{ activeSubNav('customer.*') }}">
                                        <a href="{{ route('customer.index') }}">
                                            <span class="sub-item">Customer</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('supplier-manage')
                                    <li class="{{ activeSubNav('supplier.*') }}">
                                        <a href="{{ route('supplier.index') }}">
                                            <span class="sub-item">Supplier</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('store-manage')
                                    <li class="{{ activeSubNav('company-store.*') }}">
                                        <a href="{{ route('company-store.index') }}">
                                            <span class="sub-item">Store</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('factory-manage')
                                    <li class="{{ activeSubNav('company-factory.*') }}">
                                        <a href="{{ route('company-factory.index') }}">
                                            <span class="sub-item">Factory</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                {{-- ________________________ Office Start ________________________ --}}
                <li
                    class="nav-item {{ ActiveNav([
                        'account-received.*',
                        'account-payment.*',
                        'bankDeposit.*',
                        'bankWithdraw.*',
                        'office-expense.*',
                        'officeExp.*',
                        'officeExp.*',
                        'office-income.*',
                        'officeIn.*',
                        'cashBook.*',
                        'authorLedgerBook.*',
                        'mainAccount.*',
                        'bankStatement.*',
                    ]) }}">
                    <a data-toggle="collapse" href="#office">
                        <i class="fas fa-briefcase"></i>
                        <p>@lang('nav.office')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ openNav([
                        'account-received.*',
                        'account-payment.*',
                        'bankDeposit.*',
                        'bankWithdraw.*',
                        'office-expense.*',
                        'officeExp.*',
                        'officeExp.*',
                        'office-income.*',
                        'officeIn.*',
                        'cashBook.*',
                        'authorLedgerBook.*',
                        'mainAccount.*',
                        'bankStatement.*',
                    ]) }}"
                        id="office">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-toggle="collapse" href="#accSub">
                                    <i class="fas fa-calculator sub_icon"></i>
                                    <span>@lang('nav.account')</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse {{ openNav([
                                    'account-received.*',
                                    'account-payment.*',
                                    'bankDeposit.*',
                                    'bankWithdraw.*',
                                    'office-expense.*',
                                    'officeExp.*',
                                    'officeExp.*',
                                    'office-income.*',
                                    'officeIn.*',
                                    'cashBook.*',
                                    'authorLedgerBook.*',
                                    'mainAccount.*',
                                    'bankStatement.*',
                                ]) }}"
                                    id="accSub">
                                    <ul class="nav nav-collapse subnav">
                                        @can('collection-manage')
                                            <li class="{{ activeSubNav('account-received.*') }}">
                                                <a href="{{ route('account-received.index') }}">
                                                    <span class="sub-item">Collection</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('payment-manage')
                                            <li class="{{ activeSubNav('account-payment.*') }}">
                                                <a href="{{ route('account-payment.index') }}">
                                                    <span class="sub-item">Payment</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('deposit-manage')
                                            <li class="{{ activeSubNav('bankDeposit.*') }}">
                                                <a href="{{ route('bankDeposit.dCreate') }}">
                                                    <span class="sub-item">Deposit</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('withdraw-manage')
                                            <li class="{{ activeSubNav('bankWithdraw.*') }}">
                                                <a href="{{ route('bankWithdraw.wCreate') }}">
                                                    <span class="sub-item">Withdraw</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('expense-manage')
                                            <li class="{{ activeSubNav('office-expense.*') }}">
                                                <a href="{{ route('office-expense.create') }}">
                                                    <span class="sub-item">Expense</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('expense-report-manage')
                                            <li class="{{ activeSubNav('officeExp.*') }}">
                                                <a href="{{ route('officeExp.selectDate') }}">
                                                    <span class="sub-item">Expense Report</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('income-manage')
                                            <li class="{{ activeSubNav('office-income.*') }}">
                                                <a href="{{ route('office-income.create') }}">
                                                    <span class="sub-item">Income</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('income-report-manage')
                                            <li class="{{ activeSubNav('officeIn.*') }}">
                                                <a href="{{ route('officeIn.selectDate') }}">
                                                    <span class="sub-item">Income Report</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('cashbook-manage')
                                            <li class="{{ activeSubNav('cashBook.*') }}">
                                                <a href="{{ route('cashBook.selectDate') }}">
                                                    <span class="sub-item">Cash Book</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('author-ledger-book-manage')
                                            <li class="{{ activeSubNav('authorLedgerBook.*') }}">
                                                <a href="{{ route('authorLedgerBook.index') }}">
                                                    <span class="sub-item">Author Ledger Book</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('main-account-manage')
                                            <li class="{{ activeSubNav('mainAccount.*') }}">
                                                <a href="{{ route('mainAccount.selectDate') }}">
                                                    <span class="sub-item">Main Accounts</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('bank-statement-manage')
                                            <li class="{{ activeSubNav('bankStatement.*') }}">
                                                <a href="{{ route('bankStatement.selectDate') }}">
                                                    <span class="sub-item">Bank Statement</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                            {{-- <li>
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
							</li> --}}
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
                <li
                    class="nav-item {{ activeNav([
                        'raw-material.*',
                        'purchase-bulk.*',
                        'purchaseBulk.*',
                        'sales-bulk.*',
                        'stock.bulk.*',
                        'send-to-repack-unit.*',
                        'purchaseLedgerBook.*',
                        'report.bulk.*',
                        'repackingCheck.*',
                        'bulkTracking.*',
                        'production.*',
                        'product.*',
                        'productionCheck.*',
                        'stock.store.*',
                    ]) }}">
                    <a data-toggle="collapse" href="#factory">
                        <i class="fas fa-industry"></i>
                        <p>@lang('nav.factory')</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse {{ openNav([
                        'raw-material.*',
                        'purchase-bulk.*',
                        'purchaseBulk.*',
                        'sales-bulk.*',
                        'stock.bulk.*',
                        'send-to-repack-unit.*',
                        'purchaseLedgerBook.*',
                        'report.bulk.*',
                        'repackingCheck.*',
                        'bulkTracking.*',
                        'production.*',
                        'product.*',
                        'productionCheck.*',
                        'stock.store.*',
                    ]) }}"
                        id="factory">
                        <ul class="nav nav-collapse">
                            <li>
                                <a data-toggle="collapse" href="#subRaw">
                                    <i class="fas fa-shopping-cart sub_icon"></i>
                                    <span>@lang('nav.bulk')</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse {{ openNav(['raw-material.*', 'purchase-bulk.*', 'purchaseBulk.*', 'sales-bulk.*', 'stock.bulk.*', 'send-to-repack-unit.*', 'purchaseLedgerBook.*', 'report.bulk.*']) }}"
                                    id="subRaw">
                                    <ul class="nav nav-collapse subnav">
                                        <li class="{{ activeSubNav('raw-material.*') }}">
                                            <a href="{{ route('raw-material.index') }}">
                                                <span class="sub-item">Bulk Name</span>
                                            </a>
                                        </li>
                                        <li class="{{ activeSubNav(['purchase-bulk.*', 'purchaseBulk.*']) }}">
                                            <a href="{{ route('purchase-bulk.index') }}">
                                                <span class="sub-item">Purchase</span>
                                            </a>
                                        </li>
                                        <li class="{{ activeSubNav('sales-bulk.*') }}">
                                            <a href="{{ route('sales-bulk.index') }}">
                                                <span class="sub-item">Bulk Sales</span>
                                            </a>
                                        </li>
                                        <li class="{{ activeSubNav('stock.bulk.*') }}">
                                            <a href="{{ route('stock.bulk.index') }}">
                                                <span class="sub-item">Bulk Stock</span>
                                            </a>
                                        </li>
                                        <li class="{{ activeSubNav('send-to-repack-unit.*') }}">
                                            <a href="{{ route('send-to-repack-unit.index') }}">
                                                <span class="sub-item">Send to Repack Unit</span>
                                            </a>
                                        </li>
                                        <li class="{{ activeSubNav('purchaseLedgerBook.*') }}">
                                            <a href="{{ route('purchaseLedgerBook.index') }}">
                                                <span class="sub-item">Purchase Ledger Book</span>
                                            </a>
                                        </li>
                                        <li class="{{ activeSubNav('report.bulk.*') }}">
                                            <a href="{{ route('report.bulk.selectDate') }}">
                                                <span class="sub-item">Report</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a data-toggle="collapse" href="#subRp">
                                    <i class="fas fa-parking sub_icon"></i>
                                    <span>@lang('nav.repack-unit')</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse {{ openNav(['repackingCheck.*', 'bulkTracking.*', 'production.*']) }}"
                                    id="subRp">
                                    <ul class="nav nav-collapse subnav">
                                        @can('repack-unit-qa/qc-manage')
                                            <li class="{{ activeSubNav('repackingCheck.*') }}">
                                                <a href="{{ route('repackingCheck.showAccpet') }}">
                                                    <span class="sub-item">QA/QC</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('repack-unit-production-manage')
                                            <li class="{{ activeSubNav('bulkTracking.*') }}">
                                                <a href="{{ route('bulkTracking.showInvoice') }}">
                                                    <span class="sub-item">Production</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('repack-unit-production-report-manage')
                                            <li class="{{ activeSubNav('production.*') }}">
                                                <a href="{{ route('production.selectDate') }}">
                                                    <span class="sub-item">Production Report</span>
                                                </a>
                                            </li>
                                        @endcan
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
                                    <span>@lang('nav.store')</span>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse {{ openNav(['product.*', 'productionCheck.*', 'stock.store.*']) }}"
                                    id="subFac">
                                    <ul class="nav nav-collapse subnav">
                                        @can('store-product-manage')
                                            <li class="{{ activeSubNav('product.*') }}">
                                                <a href="{{ route('product.index') }}">
                                                    <span class="sub-item">Product</span>
                                                </a>
                                            </li>
                                        @endcan
                                        <li class="{{ activeSubNav('productionCheck.*') }}">
                                            <a href="{{ route('productionCheck.showAccpet') }}">
                                                <span class="sub-item">QA/QC</span>
                                            </a>
                                        </li>
                                        <li class="{{ activeSubNav('stock.store.*') }}">
                                            <a href="{{ route('stock.store.index') }}">
                                                <span class="sub-item">Stock</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            {{-- <li>
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
                            </li> --}}
                        </ul>
                    </div>
                </li>
                {{-- ________________________ Factory End ________________________ --}}
                @if (setting('product_purchase') == 1)
                    {{-- ________________________ Product Purchase Start ________________________ --}}
                    <li
                        class="nav-item {{ activeNav(['product-purchase.*', 'purchaseProduct.*', 'purchaseLedgerBook.*']) }}">
                        <a data-toggle="collapse" href="#purchaseProduct">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <p>@lang('nav.purchase')</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ openNav(['product-purchase.*', 'purchaseProduct.*', 'purchaseLedgerBook.*']) }}"
                            id="purchaseProduct">
                            <ul class="nav nav-collapse">
                                <li class="{{ activeSubNav(['product-purchase.*', 'purchaseProduct.*']) }}">
                                    <a href="{{ route('product-purchase.index') }}">
                                        <span class="sub-item">Product</span>
                                    </a>
                                </li>
                                {{-- <li
                                class="{{ activeSubNav(['sales-invoice-cash-return.*', 'salesInvoiceCashReturn.*']) }}">
                                <a href="{{ route('sales-invoice-cash-return.index') }}">
                                    <span class="sub-item">Sales Return</span>
                                </a>
                            </li> --}}
                                <li class="{{ activeSubNav('purchaseLedgerBook.*') }}">
                                    <a href="{{ route('purchaseLedgerBook.index') }}">
                                        <span class="sub-item">Ledger Book</span>
                                    </a>
                                </li>
                                <li class="{{ activeSubNav('report.salesAndStock.*') }}">
                                    <a href="{{ route('report.salesAndStock.selectDate') }}">
                                        <span class="sub-item">@lang('nav.report')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{-- Product Purchase End --}}
                @endif


                {{-- ________________________ Sales Start ________________________ --}}
                <li
                    class="nav-item {{ activeNav(['sample-invoive.*', 'salesInvoiceCash.*', 'sales-invoice-cash.*', 'sales-invoice-cash-return.*', 'salesInvoiceCashReturn.*', 'salesLedgerBook.*', 'report.salesAndStock.*']) }}">
                    <a data-toggle="collapse" href="#invoice">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <p>@lang('nav.sales')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ openNav(['sample-invoive.*', 'salesInvoiceCash.*', 'sales-invoice-cash.*', 'sales-invoice-cash-return.*', 'salesInvoiceCashReturn.*', 'salesLedgerBook.*', 'report.salesAndStock.*']) }}"
                        id="invoice">
                        <ul class="nav nav-collapse">
                            @can('sales-sample-manage')
                                <li class="{{ activeSubNav('sample-invoive.*') }}">
                                    <a href="{{ route('sample-invoive.index') }}">
                                        <span class="sub-item">Sample</span>
                                    </a>
                                </li>
                            @endcan
                            <li class="{{ activeSubNav(['sales-invoice-cash.*', 'salesInvoiceCash.*']) }}">
                                <a href="{{ route('sales-invoice-cash.index') }}">
                                    <span class="sub-item">Sales</span>
                                </a>
                            </li>
                            <li
                                class="{{ activeSubNav(['sales-invoice-cash-return.*', 'salesInvoiceCashReturn.*']) }}">
                                <a href="{{ route('sales-invoice-cash-return.index') }}">
                                    <span class="sub-item">Sales Return</span>
                                </a>
                            </li>
                            <li class="{{ activeSubNav('salesLedgerBook.*') }}">
                                <a href="{{ route('salesLedgerBook.index') }}">
                                    <span class="sub-item">Ledger Book</span>
                                </a>
                            </li>
                            <li class="{{ activeSubNav('report.salesAndStock.*') }}">
                                <a href="{{ route('report.salesAndStock.selectDate') }}">
                                    <span class="sub-item">@lang('nav.report')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Sales End --}}

                <li class="nav-item {{ $p == 'report' ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#report">
                        <i class="fas fa-file"></i>
                        <p>@lang('nav.report')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $p == 'report' ? 'show' : '' }}" id="report">
                        <ul class="nav nav-collapse">
                            <li class="{{ $sm == 'cashBook' ? 'activeSub' : '' }}">
                                <a href="{{ route('cashBook.selectDate') }}">
                                    <span class="sub-item">Cash Book</span>
                                </a>
                            </li>
                            <li class="{{ $sm == 'bankStat' ? 'activeSub' : '' }}">
                                <a href="{{ route('bankStatement.selectDate') }}">
                                    <span class="sub-item">Bank Statement</span>
                                </a>
                            </li>
                            <li class="{{ $sm == 'officeExpRe' ? 'activeSub' : '' }}">
                                <a href="{{ route('officeExp.selectDate') }}">
                                    <span class="sub-item">Head Office Exp. Rep.</span>
                                </a>
                            </li>
                            <li class="{{ $sm == 'empReport' ? 'active' : '' }}">
                                <a href="{{ route('empReport.user') }}">
                                    <span class="sub-item">Employee Report</span>
                                </a>
                            </li>
                            <li class="{{ $sm == 'customerReport' ? 'activeSub' : '' }}">
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
                            <li class="{{ $sm == 'salesAndStock' ? 'activeSub' : '' }}">
                                <a href="{{ route('report.salesAndStock.selectDate') }}">
                                    <span class="sub-item">Sales Report</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Trash start --}}
                <li class="nav-item {{ $p == 'trash' ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#trash">
                        <i class="fas fa-trash"></i>
                        <p>@lang('nav.trash')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $p == 'trash' ? 'show' : '' }}" id="trash">
                        <ul class="nav nav-collapse">
                            <li class="{{ $sm == 'rReceived' ? 'activeSub' : '' }}">
                                <a href="{{ route('received.trash') }}">
                                    <span class="sub-item">Collection</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Trash end --}}

                {{-- <li class="nav-item {{$p=='backup'?'active':''}}">
                    <a class="dropdown-item" href="{{ route('admin.backup.password') }}" >
                        <i class="fas fa-database"></i>
                        <p>App Backup</p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item {{$p=='visitor'?'active':''}}">
                    <a class="dropdown-item" href="{{ route('admin.visitorInfo.index') }}" >
                        <i class="fas fa-user-secret"></i>
                        <p>Visitor Info</p>
                    </a>
                </li> --}}

                <li
                    class="nav-item {{ activeNav(['admin.role.*', 'admin.backup.*', 'admin.visitorInfo.*', 'admin.permission.*']) }}">
                    <a data-toggle="collapse" href="#settings">
                        <i class="fa-solid fa-gears"></i>
                        <p>@lang('nav.settings')</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ openNav(['admin.role.*', 'admin.backup.*', 'admin.visitorInfo.*', 'admin.permission.*']) }}"
                        id="settings">
                        <ul class="nav nav-collapse">
                            @canany('role-manage', 'permission-manage')
                                <li class="{{ activeSubNav('admin.role.*', 'admin.permission.*') }}">
                                    <a href="{{ route('admin.role.index') }}">
                                        <span class="sub-item">@lang('nav.role-permission')</span>
                                    </a>
                                </li>
                            @endcanany
                            @canany('backup-manage')
                                <li class="{{ activeSubNav('admin.backup.*') }}">
                                    <a href="{{ route('admin.backup.password') }}">
                                        <span class="sub-item">App Backup</span>
                                    </a>
                                </li>
                            @endcanany
                            @canany('visitor-manage')
                                <li class="{{ activeSubNav('admin.visitorInfo.*') }}">
                                    <a href="{{ route('admin.visitorInfo.index') }}">
                                        <span class="sub-item">Visitor Info</span>
                                    </a>
                                </li>
                            @endcanany
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
