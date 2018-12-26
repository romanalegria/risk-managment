@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        
    </template>

    <template v-if="menu==1">
        <perfil></perfil>
    </template>

    <template v-if="menu==2">
        <h1>Contenido del menu 2</h1>
    </template>

    <template v-if="menu==3">
        <empresa></empresa>
    </template>

    <template v-if="menu==4">
        <contratista></contratista>
    </template>

    <template v-if="menu==5">
        <modulo></modulo>
    </template>

    <template v-if="menu==6">
        <funmod></funmod>
    </template>

    <template v-if="menu==7">
        <h1>Contenido del menu 7</h1>
    </template>

    <template v-if="menu==8">
        <h1>Contenido del menu 8</h1>
    </template>

    <template v-if="menu==9">
        <h1>Contenido del menu 9</h1>
    </template>

    <template v-if="menu==10">
        <h1>Contenido del menu 10</h1>
    </template>

    <template v-if="menu==11">
        <h1>Contenido del menu 11</h1>
    </template>

    <template v-if="menu==12">
        <h1>Contenido del menu 12</h1>
    </template>
   
@endsection
