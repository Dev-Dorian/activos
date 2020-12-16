@extends('principal')
    @section('contenido')

        @if(Auth::check())
            @if (Auth::user()->idrol == 1)
                <template v-if="menu==0">
                    <dashboard></dashboard>
                </template>

                <template v-if="menu==1">
                    <categoria></categoria>
                </template>

                <template v-if="menu==2">
                    <ubicacion></ubicacion>
                </template>

                <template v-if="menu==3">
                    <responsable></responsable>
                </template>

                <template v-if="menu==4">
                    <articulo></articulo>
                </template>

                <template v-if="menu==5">
                <depreciacion></depreciacion>
                </template>

                <template v-if="menu==6">
                    <user></user>
                </template>

                <template v-if="menu==7">
                    <rol></rol>
                </template>

                <template v-if="menu==8">
                    <reportesgenerales></reportesgenerales>
                </template>

                <!--<template v-if="menu==9">
                    <h1>Contenido del menu 9</h1>
                </template>-->

                <template v-if="menu==10">
                    <auditoria></auditoria>
                </template>

                <template v-if="menu==11">                    
                    <respaldo></respaldo>
                </template>

                <template v-if="menu==12">
                    <ayuda></ayuda>
                </template>
                <template v-if="menu==13">
                    <h1>Contenido del menu 13</h1>
                </template>
            @elseif (Auth::user()->idrol == 2)
                <template v-if="menu==0">
                    <dashboard></dashboard>
                </template>
                <template v-if="menu==4">
                    <articulo></articulo>
                </template>
                <template v-if="menu==12">
                    <ayuda></ayuda>
                </template>
                <template v-if="menu==5">
                    <h1>Contenido del menu 5</h1>
                </template>
            @else
            @endif
        @endif    
    @endsection