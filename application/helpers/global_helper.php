<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");

function generate_admin_sidemenu()
{
	return '
					<li>
                        <a href="'.site_url('dashboard').'"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                    </li>
                    <li class="menu-title">Data</li><!-- /.menu-title -->
                    <li>
                        <a href="'.site_url('DataPegawai').'"><i class="menu-icon ti ti-user"></i>Pegawai</a>
                    </li>
                    <li>
                        <a href="'.site_url('DataMahasiswa').'"><i class="menu-icon fa fa-users"></i>Mahasiswa</a>
                    </li>
                    <li>
                        <a href="'.site_url('DataKelas').'"><i class="menu-icon fa fa-building-o"></i>Kelas</a>
                    </li>
                    <li>
                        <a href="'.site_url('DataMatkul').'"><i class="menu-icon fa fa-book"></i>Mata Kuliah</a>
                    </li>
                    <li class="menu-title">Perkuliahan</li><!-- /.menu-title -->
                    <li>
                        <a href="'.site_url('perkuliahandosen').'"><i class="menu-icon ti ti-agenda"></i>Dosen</a>
                    </li>
                    <li>
                        <a href="'.site_url('perkuliahanmhs').'"><i class="menu-icon ti ti-write"></i>Mahasiswa</a>
                    </li>
                    <li class="menu-title">Kehadiran</li><!-- /.menu-title -->
                    <li>
                        <a href="'.site_url('kehadirandosen').'"><i class="menu-icon ti ti-notepad"></i>Dosen</a>
                    </li>
                    <li>
                        <a href="'.site_url('KehadiranMhs').'"><i class="menu-icon ti ti-clipboard"></i>Mahasiwa</a>
                    </li>
                    <li class="menu-title">Ruangan</li><!-- /.menu-title -->
                    <li>
                        <a href="'.site_url('inforuangan').'"><i class="menu-icon ti ti-home"></i>Info Ruangan</a>
                    </li>
                    <li class="menu-title">Pendukung</li><!-- /.menu-title -->
                    <li>
                        <a href="'.site_url('ProgramStudi').'"><i class="menu-icon fa fa-sitemap"></i>Program Studi</a>
                    </li>
                    <li>
                        <a href="'.site_url('Angkatan').'"><i class="menu-icon ti ti-flag-alt-2"></i>Angkatan</a>
                    </li>
                    <li>
                        <a href="'.site_url('TahunAjaran').'"><i class="menu-icon fa fa-calendar"></i>Tahun Ajaran</a>
                    </li>
        	';
}
