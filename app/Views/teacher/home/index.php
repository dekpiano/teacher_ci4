<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
หน้าแรก
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <!-- <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard v2</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard v2</li>
                    </ol>
                </div>
            </div> -->
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
<div class="app-content">
	<!--begin::Container-->
	<div class="container-fluid">

		<style>
			/* Minimal dashboard design (updated with category styles) */
			:root{
				--card-bg: #ffffff;
				--muted: #6c757d;
				--accent: #0d6efd;
				--tile-border: rgba(0,0,0,0.06);
				--radius: 10px;
			}
			.dashboard-welcome{
				display:flex;
				align-items:center;
				gap:1rem;
				padding:1.25rem;
				background:var(--card-bg);
				border-radius:var(--radius);
				box-shadow:0 6px 18px rgba(22,27,34,0.04);
				text-align:left;
			}
			.dashboard-welcome .avatar{
				flex:0 0 64px;
				width:64px;
				height:64px;
				border-radius:8px;
				display:grid;
				place-items:center;
				background:linear-gradient(180deg, rgba(13,110,253,0.08), rgba(13,110,253,0.02));
				color:var(--accent);
				font-size:2rem;
			}
			.dashboard-welcome h4{ margin:0; font-weight:600; }
			.dashboard-welcome p{ margin:0; color:var(--muted); font-size:.95rem; }

			/* Tile grid */
			.dashboard-grid{
				display:grid;
				grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));
				gap:1rem;
			}
			.tile{
				display:flex;
				flex-direction:column;
				justify-content:center;
				padding:1rem;
				background:var(--card-bg);
				border-radius:var(--radius);
				border:1px solid var(--tile-border);
				box-shadow:0 6px 18px rgba(22,27,34,0.03);
				transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease;
				text-decoration:none;
				color:inherit;
				min-height:96px;
			}
			.tile:hover, .tile:focus{
				transform:translateY(-4px);
				box-shadow:0 12px 30px rgba(22,27,34,0.06);
				border-color:rgba(13,110,253,0.12);
				text-decoration:none;
			}
			.tile .meta{ display:flex; align-items:center; justify-content:space-between; gap:.5rem; }
			.tile .title{ display:flex; align-items:center; gap:.75rem; font-weight:600; }
			.tile .title .icon{
				font-size:1.4rem;
				color:var(--accent);
				width:36px;
				height:36px;
				display:grid;
				place-items:center;
				background:rgba(13,110,253,0.06);
				border-radius:8px;
			}
			.tile .desc{ margin-top:.5rem; color:var(--muted); font-size:.92rem; }

			.section-header{ display:flex; align-items:center; gap:1rem; margin-bottom:.5rem; }
			.section-header h3{ margin:0; font-size:1.05rem; font-weight:600; }

			/* category specific */
			.category{
				margin-top:1rem;
				padding:0.75rem;
				border-radius:var(--radius);
				background:transparent;
				border:1px solid rgba(0,0,0,0.03);
			}
			.category-header{
				display:flex;
				align-items:center;
				gap:.6rem;
				margin-bottom:.6rem;
				padding:0.35rem 0.25rem;
				color:var(--muted);
				font-weight:600;
			}
			.category-header .label{
				font-weight:700;
				color:inherit;
			}
			.category-sub{ color:var(--muted); font-size:.92rem; margin-bottom:.6rem; }

			@media (max-width:575px){ .dashboard-welcome{flex-direction:row} }
		</style>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary card-outline card-min">
					<div class="card-body">
						<!-- replaced welcome block with minimal layout -->
						<div class="dashboard-welcome" role="region" aria-label="welcome">
							<div class="avatar" aria-hidden="true"><i class="bi bi-person-fill"></i></div>
							<div>
								<h4>
									ยินดีต้อนรับ, ครู <?= session()->get('fullname')?>
									<?php if (isset($homeroomClass) && $homeroomClass): ?>
										<span class="text-muted fw-normal">(ครูประจำชั้น ม.<?= esc($homeroomClass->Reg_Class) ?>)</span>
									<?php endif; ?>
								</h4>
								<p>ระบบบริหารจัดการข้อมูลสำหรับครู โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Categorized grids -->
		<div class="row mt-3">
			<div class="col-12">
				<!-- Grading category (unchanged position) -->
				<div class="category">
					<div class="category-header">
						<i class="bi bi-file-earmark-plus"></i>
						<span class="label">งานวัดผล</span>
					</div>
					<div class="dashboard-grid" role="list">
						<a role="listitem" class="tile" href="<?= base_url('assessment/save-score-normal') ?>" aria-label="บันทึกผลการเรียน ปกติ">
							<div class="meta">
								<div class="title">
									<div class="icon"><i class="bi bi-file-earmark-text"></i></div>
									<span>บันทึกผลการเรียน (ปกติ)</span>
								</div>
								<div class="chev"><i class="bi bi-arrow-right-circle-fill text-muted"></i></div>
							</div>
							<div class="desc">บันทึกคะแนนและผลการเรียนของนักเรียนในรายวิชาปกติ</div>
						</a>

						<a role="listitem" class="tile" href="<?= base_url('assessment/save-score-repeat') ?>" aria-label="บันทึกผลการเรียน ซ้ำ">
							<div class="meta">
								<div class="title">
									<div class="icon"><i class="bi bi-repeat"></i></div>
									<span>บันทึกผลการเรียน (ซ้ำ)</span>
								</div>
								<div class="chev"><i class="bi bi-arrow-right-circle-fill text-muted"></i></div>
							</div>
							<div class="desc">บันทึกคะแนนและผลการเรียนของนักเรียนที่เรียนซ้ำ</div>
						</a>
					</div>
				</div>

				<!-- Curriculum category (keep here) -->
				<div class="category">
					<div class="category-header">
						<i class="bi bi-book"></i>
						<span class="label">งานหลักสูตร</span>
					</div>
					<div class="dashboard-grid" role="list">
						<a role="listitem" class="tile" href="<?= base_url('curriculum/SendPlan') ?>" aria-label="ส่งแผนการสอน">
							<div class="meta">
								<div class="title">
									<div class="icon"><i class="bi bi-cloud-upload"></i></div>
									<span>ส่งแผนการสอน</span>
								</div>
								<div class="chev"><i class="bi bi-arrow-right-circle-fill text-muted"></i></div>
							</div>
							<div class="desc">อัปโหลดและส่งแผนการสอนเพื่อขออนุมัติ</div>
						</a>

						<a role="listitem" class="tile" href="<?= base_url('curriculum/download-plan') ?>" aria-label="ดาวน์โหลดแผน">
							<div class="meta">
								<div class="title">
									<div class="icon"><i class="bi bi-cloud-download"></i></div>
									<span>ดาวน์โหลดแผน</span>
								</div>
								<div class="chev"><i class="bi bi-arrow-right-circle-fill text-muted"></i></div>
							</div>
							<div class="desc">ดาวน์โหลดแผนการสอนที่ได้รับอนุมัติแล้ว</div>
						</a>

						<?php if (session()->get('pers_groupleade') !== null && session()->get('pers_groupleade') !== ''): ?>
						<a role="listitem" class="tile" href="<?= base_url('curriculum/check-plan-head') ?>" aria-label="ตรวจแผน หน.กลุ่มสาระ">
							<div class="meta">
								<div class="title">
									<div class="icon"><i class="bi bi-clipboard-check"></i></div>
									<span>ตรวจแผน (หน.กลุ่มสาระ)</span>
								</div>
								<div class="chev"><i class="bi bi-arrow-right-circle-fill text-muted"></i></div>
							</div>
							<div class="desc">ตรวจสอบและอนุมัติแผนการสอนของครูในกลุ่มสาระ</div>
						</a>
						<?php endif; ?>
					</div>
				</div>

				<!-- Assessment category (MOVED here, below Curriculum) -->
				<div class="category">
					<div class="category-header">
						<i class="bi bi-clipboard-check"></i>
						<span class="label">งานประเมินนักเรียน</span>
					</div>
					<div class="dashboard-grid" role="list">
						<a role="listitem" class="tile" href="<?= base_url('teacher/reading_assessment') ?>" aria-label="แบบประเมินอ่านคิดวิเคราะห์">
							<div class="meta">
								<div class="title">
									<div class="icon"><i class="bi bi-book-half"></i></div>
									<span>แบบประเมินอ่านคิดวิเคราะห์</span>
								</div>
								<div class="chev"><i class="bi bi-arrow-right-circle-fill text-muted"></i></div>
							</div>
							<div class="desc">ประเมินความสามารถในการอ่าน คิดวิเคราะห์ และเขียนของนักเรียน</div>
						</a>

						<a role="listitem" class="tile" href="<?= base_url('teacher/desirable_assessment') ?>" aria-label="คุณลักษณะอันพึงประสงค์">
							<div class="meta">
								<div class="title">
									<div class="icon"><i class="bi bi-check2-circle"></i></div>
									<span>คุณลักษณะอันพึงประสงค์</span>
								</div>
								<div class="chev"><i class="bi bi-arrow-right-circle-fill text-muted"></i></div>
							</div>
							<div class="desc">ประเมินคุณลักษณะอันพึงประสงค์ 8 ประการของนักเรียน</div>
						</a>
					</div>
				</div>

				<!-- Others category (unchanged) -->
				<div class="category">
					<div class="category-header">
						<i class="bi bi-palette"></i>
						<span class="label">งานประกันคุณภาพ</span>
					</div>
					<div class="dashboard-grid" role="list">
						<a role="listitem" class="tile" href="#" aria-label="งานประกันคุณภาพ">
							<div class="meta">
								<div class="title">
									<div class="icon"><i class="bi bi-shield-check"></i></div>
									<span>งานประกันคุณภาพ</span>
								</div>
								<div class="chev"><i class="bi bi-arrow-right-circle-fill text-muted"></i></div>
							</div>
							<div class="desc">จัดการข้อมูลและเอกสารที่เกี่ยวข้องกับงานประกันคุณภาพ</div>
						</a>
					</div>
				</div>

			</div>
		</div>

		<!-- ...existing code... -->

	</div>
	<!--end::Container-->
</div>
<!--end::App Content-->
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>