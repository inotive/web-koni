@extends('layouts.app')

@section('pageTitle', 'Cabor Permainan')
@section('mainSection', 'Laporan LPJ')
@section('subSection', 'Bidang Bidang')
@section('subSectionUrl', route('admin.laporan-lpj.bidang.index'))
@section('subSection2', 'Pembinaan Prestasi')
@section('subSection2Url', route('admin.laporan-lpj.bidang.prestasi.index'))
@section('currentSection', 'Cabor Permainan')
