/*
 * Universidad de San Carlos de Guatemala
 * Facultad de Ingenieria
 * Escuela de Ciencias y Sistemas
 * Manejo e implementacion de archivos
 * Seccion A
 * Laboratorio
 * Practica 1
 * 12/06/2016 23:59 hrs
 *
 * Carlos Josue Monterroso Barrios
 * 201314646
 *
 */

/**********************Area de librerias***************************************/
#include <stdio.h>
//atoi
#include <stdlib.h>
//directorios
#include <dirent.h>
//crear directorios
#include <sys/stat.h>
//comparacion de cadenas
#include <string.h>
//timeq
#include <time.h>
//-----------------------------------------------------------------

/******************************************************************************/
/********************Area de variables globales********************************/
/******************************************************************************/

//-----------Contador Instrucciones y Errores------/
int ContadorInstrucciones=0;
int ContadorComandosExitosos=0;

int ErrorInterprete=0;
int ErrorComando=0;
int ErrorCrearDisco=0;
int ErrorEliminarDisco=0;
int ErrorCrearParticionPrimaria=0;
int ErrorEliminarParticionPrimaria=0;
int ErrorCrearParticionLogica=0;
int ErrorEliminarLogica=0;
int ErrorMontar=0;
int ErrorReporte1=0;
int ErrorReporte2=0;
int ErrorDesmontar=0;
int ErrorFormatear=0;
int ErrorReporte3=0;
int ErrorT=0;

int fin=0;

char Dot_MBR[5000];
char Dot_EBR[5000]=" ";
int switch_mbr=0;
int switch_ebr=0;

char cadG[5000];
char cadE[5000];
char cadd[5000];//variable global q concatena los Dot
char caddblock[15000];//variable global q concatena los Dot

char sincomillas[1000];// se usa en el Metodo quitarComillas
//-----------------------------------------------/

//-------Auxiliares de Concatenar----------------/
char *auxconc;
char *auxconc2;
//-----------------------------------------------/

/*
 * 
 */
/******************************************************************************/
/********************Area de Structs*******************************************/
/******************************************************************************/
typedef struct
{

    int esnuevonodo;
    char nombre[100];
    char name2[100];
    int contador;
    char nombreparametro[100];
    char parametro[100];
    int size;
    char size2[100];
    char unit;
    char path[100];
    char type;
    char typeFormatear[100];
    char delete_[100];
    char name[100];
    char Contenido[1000];
    char id[100];
    char fileid[100];
    int add;
    char fit[100];
    char allocation[100];
    char idvector[6];
    int p;
    char fs[100];

    char count[100];
    int count2;

}Funcion;

typedef struct
{
    char part_status;
    char part_type;
    char part_fit;
    char part_allocation;
    int part_start;
    int part_size;
    char part_name[16];
    int formateada;

}Particion;

typedef struct
{
    int mbr_tamano;
    char mbr_fecha_creacion[25];
    int mbr_disk_signature;
    Particion particiones[4];
}MbrDisco;

typedef struct
{
    char part_status;
    char part_fit;
    int part_start;
    int part_size;
    int part_next;
    char part_name[16];
}EBR;

typedef struct
{
    
//ESTRUCTURA PARA LOS MONTADOS
    int estado;
    char id[5];

    
}Posicion;


typedef struct
{
    char path[200];
    char *path2;
    Posicion posicion[26];
    
    
}Montaje;



typedef struct
{
    int status;
    char path3[100];
    char *path2;
    char letrafinal;
    int numerofinal;
    
    char id[6];
    //char*idpuntero;
    
    char*name;
    char name2[100];
    
}Montaje2;


typedef struct
{
    int status;
    char letra;
    int numero;
    char pathPerteneciente[200];
    char *pathPertenecienteP;
    
    
    int posiciones[26];
    
}letra;

typedef struct
{
    
    char id[100];
    
}ids;


typedef struct
{ 
    int bit;
    
}Bitmap;

typedef struct
{
    
    char nombre[16];
    char info[50];
    
}Bloque;

typedef struct
{

    Bloque b;
    int Pos;
    
}ListaBloques;

typedef struct
{

    int posEnBitmap;
    int NbloquesLibres;
    
}Ajuste;
//--------------------------Montar Variables------------------------------------
Montaje montadas[20];
Montaje2 montadas2[50];
letra letras[26];

ids listaIds[20];
ids listaIds2[20];

int NumeroDeMontadas=0;
int auxletras=0;
Montaje2 resienMontada;
int posDeMontada_rep=0;
//------------------------------------------------------------------------------

/*
 * 
 */
/******************************************************************************/
/********************Area de Metodos Herramienta*******************************/
/******************************************************************************/

//metodo Limpia la Variable
void limpiarvar(char aux[], int n) {
    int i;
    for (i = 0; i < n; i++) {
        aux[i] = '\0';
    }
}

//Verifica si el Char es una LETRA de la A-z
int EsLetra(char caracter)
{
    if((caracter >= 'a' && caracter <= 'z' ) || (caracter >= 'A' && caracter <= 'Z' ))
    {
        return 1;
    }else
    {
        return 0;
    }
}

//retorna 0 si la cadena es numero
int CadenaEsNumero(char entrada[])
{
    int resultado=0;
    int contador=0;
    while(entrada[contador])
    {
        if(EsNumero(entrada[contador])==0)
        {
            resultado++;
        }
        contador++;
    }
    return resultado;
}

//Verifica si el Char es un numero del 0-9
int EsNumero (char caracter2[])
{
    if(caracter2 >= '0' && caracter2 <= '9')
    {
        return 1;
    }else
    {
        return 0;
    }

}

char*ConcatenarCadenaCaracter(char* cadena,char caracter)
{
    auxconc=(char*)malloc(1+(strlen(cadena)+1));
    int contador=0;
    while (contador<(strlen(cadena)))
    {
        auxconc[contador]=cadena[contador];
        contador++;
    }
    auxconc[contador]=caracter;
    contador++;

    while(auxconc[contador]!=NULL)
    {
        auxconc[contador]=NULL;
        contador++;
    }
    return auxconc;
}

char* LeerScript(char path[])
{
    char* pathoriginal=path;
    char finalizado[250];
    strcpy(finalizado,"cd /\n");
    if(pathoriginal[0]=='\"')
    {
        pathoriginal++;
        path++;
        int q=0;
        while(path[q]!='\"')
        {
            q++;
        }
        path[q]='\0';
        pathoriginal[q]='\0';
    }
    FILE *archivo;
    char caracter;
    char* cadenafinal="";
    archivo = fopen(path,"r");

    if (archivo == NULL)
    {
        cadenafinal="Archivo No Encontrado en el Directorio";
	printf("\n::::::::::::::::::::::::::::Error_2.1 de apertura del archivo. \n\n");
        ErrorInterprete++;
    }
    else
    {
        printf("\n:::::El contenido del archivo de prueba es:::::: \n\n");
        int n=0;
        char nuevo;
        int contador=0;
        while(feof(archivo)==0){
        fseek(archivo,(sizeof(char)*contador),SEEK_SET);
        fread(&nuevo,sizeof(char),1,archivo);
        cadenafinal=ConcatenarCadenaCaracter(cadenafinal,nuevo);
	contador++;
        }
        fclose(archivo);
    }

    return cadenafinal;
}

void quitarComillas (char a[100]){
    
    limpiarvar(sincomillas,1000);
    char pathauxiliar[100];
    strcpy(pathauxiliar,a);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");

    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(a,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(a,c2,1);
            q++;
        }

    }
    
    strcpy(sincomillas,a);
    
}




/*
 * 
 */
/******************************************************************************/
/******************** INICiO De METODOS DE Manejo de Errores ******************/
/******************************************************************************/
//Metodo de Limpiar Variables de Error
void Errores_Limpiar_Variables (){
    
        //--------------Variables de Errores-----------------------------------/
        ErrorT=0;
        ErrorInterprete=0;
        ErrorComando=0;
        ErrorCrearDisco=0;
        ErrorEliminarDisco=0;
        ErrorCrearParticionPrimaria=0;
        ErrorEliminarParticionPrimaria=0;
        ErrorCrearParticionLogica=0;
        ErrorEliminarLogica=0;
        ErrorMontar=0;
        ErrorReporte1=0;
        ErrorReporte2=0;
        ErrorDesmontar=0;
        ErrorFormatear=0;
        ErrorReporte3=0;

        ContadorInstrucciones=0;
        ContadorComandosExitosos=0;
        fin=0;
        //--------------Fin de Variables de Error------------------------------/

}

//Metodo de Imprimir Errores
void Imprimir_Errores (){

        //-----------Imprime Errores-------------------------------------------/
        ErrorT=ErrorComando+ErrorInterprete+ErrorCrearDisco+ErrorEliminarDisco+ErrorCrearParticionPrimaria+ErrorCrearParticionLogica+ErrorEliminarParticionPrimaria+ErrorEliminarLogica+ErrorMontar+ErrorReporte1+ErrorReporte2+ErrorDesmontar;
        printf("\n");
        printf("|---------------------------------|\n");
        printf("|(*)Errores Generales:   '%i'      |\n",ErrorT);
        printf("|-Errores Interprete:    '%i'      |\n",ErrorInterprete);
        printf("|-Errores Comando:       '%i'      |\n",ErrorComando);
        printf("|-Errores CrearDisco:    '%i'      |\n",ErrorCrearDisco);
        printf("|-Errores EliminarDisco: '%i'      |\n",ErrorEliminarDisco);
        printf("|-Errores CrearPartPrim: '%i'      |\n",ErrorCrearParticionPrimaria);
        printf("|-Errores CrearPartLog:  '%i'      |\n",ErrorCrearParticionLogica);
        printf("|-Errores ElimPartPrim:  '%i'      |\n",ErrorEliminarParticionPrimaria);
        printf("|-Errores ElimPartLogi:  '%i'      |\n",ErrorEliminarLogica);
        printf("|-Errores MontarPart:    '%i'      |\n",ErrorMontar);
        printf("|-Errores DesmonPart:    '%i'      |\n",ErrorDesmontar);
        printf("|-Errores Reporte MBR:   '%i'      |\n",ErrorReporte1);
        printf("|-Errores Reporte Disk:  '%i'      |\n",ErrorReporte2);
        printf("|-Errores Formatear:     '%i'      |\n",ErrorFormatear);
        printf("|-Errores Reporte Block: '%i'      |\n",ErrorReporte3);
        printf("|                                 |\n");
        printf("|+Instrucciones Ejetutadas:  '%i'  |\n",ContadorInstrucciones);
        printf("|+Instrucciones Exitosas  :  '%i'  |\n",ContadorComandosExitosos);
        printf("|---------------------------------|\n");
        printf("\n|*******Fin del programa*********|\n");
        ErrorT=0;
        ErrorInterprete=0;
        ErrorComando=0;
        ErrorCrearDisco=0;
        ErrorEliminarDisco=0;
        ErrorCrearParticionPrimaria=0;
        ErrorEliminarParticionPrimaria=0;
        ErrorCrearParticionLogica=0;
        ErrorEliminarLogica=0;
        ErrorMontar=0;
        ErrorReporte1=0;
        ErrorReporte2=0;
        ErrorDesmontar=0;
        ErrorFormatear=0;
        ErrorReporte3=0;

        ContadorInstrucciones=0;
        ContadorComandosExitosos=0;
        fin=0;
        //-----------------Fin Impresion Errores-------------------------------/
    
}

/*




 * 


 *  *  *  *  *  *  * 
 */
/******************************************************************************/
/******************** INICiO De METODOS DEL PROGRAMA **************************/
/******************************************************************************/
//*metodo1
int main (){

    //llena los Arreglos de Las Montadas DE PArticiones
    llenarletras();
        
        int n=5;
        int array[n];
        for(int x=0; x<n; x++){
            array[x]=x;
        }
        
        int i, j, k, aux;
        
        for(i=1; i<n; i++){
            
            for(j=0; j<n-1; j++){
            
                if(array[j]<array[j+1]){
                    aux=array[j];
                    array[j]=array[j+1];
                    array[j+1]=aux;        
                }
            }
        }
        
         for(k=0; k<n; k++){
             printf("Print %i\n",array[k]);
         }
        
        
    //inicia El lanzador del programa
    menu_principal();
    //termino el programa
	printf("\n");
	printf("::::::::::::::::::::::::::::::::: \n");
	printf("\n");
	printf("\n");
   	printf("Carlos Monterroso 201314646 \n");
   	printf("\n");
   	printf("Apagando el sistema... \n");
   	printf("\n");
   	printf("\n");
   	printf("::::::::::::::::::::::::::::::::: \n");
        


    return 0;
}
//*metodo2
void menu_principal (){
    int opcion=1;
    char comando[100];

    while(strcmp(comando,"exit")!=0)
    {
       /***********************************************************************/
       /***************************Menu Principal******************************/
       /***********************************************************************/
        printf("%s\n", "_____________________________________________________________________");
        printf("                   %s\n", "Sistema de Archivos");
        printf("                   %s\n", " ");
        printf("              %s\n", "LWH (LINUX – WINDOWS Híbrido)");
        printf("%s\n", "_____________________________________________________________________");
        printf("%s\n", "");
        printf("%s\n", "'Bienvenido'");
        printf("%s\n", "Ingresar Comando:");
        printf("%s\n", "");
        printf(">>>>:~$ ");

        //limpiarvar(comando,100);
        scanf(" %[^\n]", comando);

       /*----------------------------------------------------------------------*/

       /***********************************************************************/
       /***********************Seleccion de Opciones****************************/
       /***********************************************************************/
        
                Errores_Limpiar_Variables();//*******METODO DEL Limpira Errores
                Interprete(comando);//*************METODO DEL INTERPRETE
                Imprimir_Errores();//*************METODO DEL Imprimir Errores
                
                //fgets(comando,100,stdin);
                //LeerComando(comando);

                

    }

}

void Interprete(char entrada[])
{
    //--------------------------------------------------------------------------
    //----------------VARIABLES GLOBALES----------------------------------------
    //--------------------------------------------------------------------------
    Funcion nuevafuncion;
    int contadorIds=0;
    int idlistado=0;
    int contadorIds2=0;
    int idlistado2=0;
    int size=0;
    int unit=0;
    int path=0;
    int type=0;
    int name=0;
    int contenido=0;
    int delete_=0;
    int add=0;
    int fit=0;
    int allocation=0;
    int fs=0;
    int id=0;
    int fileid=0;
    int numeroparametros=0;
    int barraactiva=0;
    int contador=0;
    int p=0;
    int count=0;
    int activarmount=0;
    int contadorParametrosObligatorios=0;
    char instruccion[100];
    limpiarvar(instruccion,100);
    char nombreparametro[100];
    limpiarvar(nombreparametro,100);
    char parametro[1000];
    limpiarvar(parametro,1000);
    nuevafuncion.count2=0;

    printf(" Ejecutando...\n");
    printf(".\n");
    printf(".\n");
    printf(".\n");
    printf("**************************************************************************\n");
    printf("****************************INICIO INTERPRETE ****************************\n");
    printf("**************************************************************************\n");
    printf( "Se A Ejecutado ----- Interprete:: \"%s\" \n", entrada );
    
    //--------------------------------------------------------------------------
    //-------------------INICIO DEL INTERPRETE----------------------------------
    //--------------------------------------------------------------------------
    
    while(entrada[contador]!=NULL){// while1
    
        if(entrada[contador]=='#')//-------------------------SI es Un Comentario
        {
            //printf("Interprete(1)#: Reconocido COMENTARIO\n");
            while(entrada[contador]!='\n' && entrada[contador]!='\0')
            {
                contador++;
            }
        }
        else if(entrada[contador]==' ')//------------------si es espacio blanco
        {

            //printf("Reconocido: ESPACIO\n");
            contador++;

        }
        else if(EsLetra(entrada[contador])==1){//--------------------SI es letra

            while(EsLetra(entrada[contador])==1)
            {
                char y1[1];
                y1[0]=entrada[contador];
                strncat(instruccion,y1,1);
                contador++;
            }

            size=0;
            unit=0;
            path=0;
            type=0;
            fit=0;
            allocation=0;
            delete_=0;
            name=0;
            add=0;
            numeroparametros=0;
            
            id=0;
            idlistado=0;
            
            idlistado2=0;
            
            contenido=0;
            allocation=0;
            fs=0;
            fileid=0;

            //QUITA MAYusculas--------------------------------------------------
            int contadormay=0;
            while(instruccion[contadormay])
            {
                instruccion[contadormay]=tolower(instruccion[contadormay]);
                contadormay++;
            }


            strcpy(nuevafuncion.nombre,instruccion);
            //printf("Interprete (1)#: El Nombre de La Instruccion es::= %s\n ", nuevafuncion.nombre);

        }
        else if(entrada[contador]=='\\')//--------------------si es doble barra
        {
            contador++;
            if(entrada[contador]=='^'){
                barraactiva=1;
                printf("Reconocido: CONTINUA EL MISMO COMANDO EN OTRA LINEA ABAJO ::::::\n");
                contador=contador+2;
            }else{
            // ERRRORR
                printf("Interprete(X)#: _ ERROR_1.1 Sintaxis Incorrecta Se Esperaba '^' \n");
                ErrorInterprete++;
            }   
        }
        else if(entrada[contador]=='%'){//---------------------------si es %    PARAMETROS OPCIONALES

            //-----------------------------------------------------------------/
            //-                 parametros con y sin comillas                 -/
            //-----------------------------------------------------------------/
            numeroparametros++;
            contador++;
            while(entrada[contador]!='-')//limite del parametro(-parm:x) 
            {
                //guarda todo el texto anterior a '-' en nombreparametro
                char y2[1];
                y2[0]=entrada[contador];
                strncat(nombreparametro,y2,1);
                contador++;
            }
            
            if(entrada[contador]=='-' && entrada[contador+1]=='>'){
                
                 contador=contador+2;
                 int contadorpar=0;
                 while(nombreparametro[contadorpar])
                 {
                     nombreparametro[contadorpar]=tolower(nombreparametro[contadorpar]);
                     contadorpar++;
                 }
                 //printf("Interprete (1)#:Parametro Reconocido (sin mayusculas)::= %s\n",nombreparametro);
                 
                 char prueba;

                 if(entrada[contador]!='\"')//si no hay comillas en el contenido del parametro
                 {
                     while(entrada[contador]!=' ' && entrada[contador]!='\n' && entrada[contador]!='#' && entrada[contador]!=NULL)
                     {
                     char y3[1];
                     y3[0]=entrada[contador];
                     strncat(parametro,y3,1);
                     contador++;
                     }

                     //printf("Interprete (1)#:Contenido Parametro Sin Comillas= %s\n",parametro);
                     char fn[1];
                     fn[0]='\0';
                     strncat(parametro,fn,1);

                 }else //si existieran comillas en el parametro
                 {
                     char y4[1];
                     y4[0]=entrada[contador];
                     strncat(parametro,y4,1);
                     contador++;
                     while(entrada[contador]!='\"') //&& entrada[contador]!=' ' esto se quita si truena
                     {
                     prueba=entrada[contador];
                     char y5[1];
                     y5[0]=entrada[contador];
                     strncat(parametro,y5,1);

                         contador++;
                     }
                     char y6[1];
                     y6[0]=entrada[contador];
                     strncat(parametro,y6,1);
                     contador++;
                     char fn[1];
                     fn[0]='\0';
                     strncat(parametro,fn,1);
                     //printf("Interprete (1)#:Contenido de Un Parametro con Comillas = %s\n",parametro);
                 }
            }
            else{

            printf("Interprete (X)#: _ ERROR_1.1 Sintaxis Incorrecta Se Esperaba '->' \n");
            ErrorInterprete++;

            }
            //-----------------------------------------------------------------/
            //-                Reservadas de Parametros                       -/
            //-----------------------------------------------------------------/
            
            if(!strcmp(nombreparametro,"size"))//---------------si reconoce size
            {
             //VAlida Que el SIZE SEA UN NUMERO y mayor a 0
                size=1;
                if(CadenaEsNumero(parametro)==0)
                {
                    nuevafuncion.size=atoi(parametro);
                    printf("size: %i\n",nuevafuncion.size);

                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);

                }else if(parametro[0]=='-')
                {
                    //parametro++;(aqui se puede cagar esta mierda))
                    if(CadenaEsNumero(parametro)==0)
                    {
                        nuevafuncion.size=atoi(parametro)*-1;
                        printf("size: %i\n",nuevafuncion.size);
                        limpiarvar(parametro,1000);
                        limpiarvar(nombreparametro,100);
                    }
                }else{
                    printf("\nInterprete (X)#: _ ERROR_1.2: Parametro de 'size' Invalido \n\n");
                    ErrorInterprete++;
                    size=0;
                }                     
            }else
            if(!strcmp(nombreparametro,"path"))//---------------si reconoce path
            {
                //agrega el directorio
                path=1;
                strcpy(nuevafuncion.path,parametro);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);

            }else
            if(!strcmp(nombreparametro,"name"))//------------------reconoce name
            {
                name=1;
                char env[1000];
                strcpy(env,parametro);
                quitarComillas(env);
                strcpy(nuevafuncion.name,sincomillas);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }else
            if(!strcmp(nombreparametro,"unit"))//---------------si reconoce unit
            {
                unit=2;
                //validacion para reconocer solo 'm' y 'k' como dimencionales
                if(parametro[0]=='m' || parametro[0]=='k' || parametro[0]=='b'||parametro[0]=='M' || parametro[0]=='K' || parametro[0]=='B')
                {
                    nuevafuncion.unit=parametro[0];
                    printf("unit: %c\n",nuevafuncion.unit);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else
                {
                    unit=0;
                    printf("\nInterprete (x)#: _ ERROR_1.7: Parametro de 'unit' Invalido \n\n");
                    ErrorInterprete++;
                }
            }else
            if(!strcmp(nombreparametro,"type"))//------------------reconoce type
            {

                type=2;
                if(parametro[0]=='p' || parametro[0]=='e'  || parametro[0]=='l'||parametro[0]=='P' || parametro[0]=='E'  || parametro[0]=='L'){
                    nuevafuncion.type=parametro[0];
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }else if(!strcmp(parametro,"fast") || !strcmp(parametro,"full")){
                    
                    strcpy(nuevafuncion.typeFormatear,parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else{
                type=0;
                    printf("\n Interprete (X)#: _ ERROR_3.4: Parametro de 'type' Invalido \n\n");
                    ErrorInterprete++;
                }

            }else
            if(!strcmp(nombreparametro,"fit"))//--------------------reconoce fit
            {

                fit=2;
                if(!strcmp(parametro,"bf") || !strcmp(parametro,"ff") || !strcmp(parametro,"wf")||!strcmp(parametro,"BF") || !strcmp(parametro,"FF") || !strcmp(parametro,"WF")  )
                {
                    strcpy(nuevafuncion.fit,parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else
                {
                    fit=0;
                    printf("\nInterprete (X)#: _ ERROR: Parametro de 'fit' Invalido \n\n");
                    ErrorInterprete++;
                }

            }else
            if(!strcmp(nombreparametro,"allocation"))//--------------------reconoce Allocation
            {

                allocation=2;
                if(parametro[0]=='c'  || parametro[0]=='C'  || parametro[0]=='e' || parametro[0]=='E'  || !strcmp(parametro,"IX") || !strcmp(parametro,"ix") || !strcmp(parametro,"Ix") || !strcmp(parametro,"iX"))
                {
                    strcpy(nuevafuncion.allocation,parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else
                {
                    allocation=0;
                    printf("\nInterprete (X)#: _ ERROR: Parametro de 'allocation' Invalido \n\n");
                    ErrorInterprete++;
                }
                
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);

            }else
            if(!strcmp(nombreparametro,"delete"))//--------------reconoce delete
            {
                delete_=2;
                if((!strcmp(parametro,"fast")) || (!strcmp(parametro,"full"))||(!strcmp(parametro,"FULL")) || (!strcmp(parametro,"FAST")) )
                {
                    strcpy(nuevafuncion.delete_,parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else
                {
                    delete_=0;
                    printf("\nInterprete (X)#: _ ERROR_3.5: Parametro de 'delete' Invalido \n\n");
                    ErrorInterprete++;
                }
            }else
            if(!strcmp(nombreparametro,"add"))//--------------------reconoce add
            {

                add=2;
                if(CadenaEsNumero(parametro)==0)
                {
                    nuevafuncion.add=atoi(parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else if(parametro[0]=='-')
                {
                    if(CadenaEsNumero(parametro)==0)
                    {
                        nuevafuncion.add=atoi(parametro)*-1;
                        limpiarvar(parametro,1000);
                        limpiarvar(nombreparametro,100);
                    }
                }
                else{
                    printf("\nInterprete (X)#: _ ERROR_3.6: Parametro de 'add' Invalido (debe ser numero)\n\n");
                    ErrorInterprete++;
                    add=0;
                }

            }else
            if(!strcmp(nombreparametro,"fs"))//--------------------reconoce fs
            {
                fs=1;
                char env[100];
                strcpy(env,parametro);
                quitarComillas(env);
                strcpy(nuevafuncion.fs,sincomillas);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }else
            if(!strcmp(nombreparametro,"contenido"))//------------------reconoce name
            {
                contenido=1;
                char env[1000];
                //strcpy(env,parametro);
                //quitarComillas(env);
                strcpy(nuevafuncion.Contenido,parametro);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }else
            if(!strcmp(nombreparametro,"fileid"))//------------------reconoce name
            {
                fileid=1;
                idlistado2=1;
                strcpy(listaIds2[contadorIds2].id,parametro);
                contadorIds2++;
                //strcpy(nuevafuncion.fileid,parametro);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }
            else{
            printf("\nInterprete (X)#: _ ERROR_1.5: Parametro Opcional Invalido \n\n");
            ErrorInterprete++;
            }
            
            
        }
        else if(entrada[contador]=='&'){//---------------------------si es &    PARAMETROS Obligatorios

            //-----------------------------------------------------------------/
            //-                 parametros con y sin comillas                 -/
            //-----------------------------------------------------------------/
            numeroparametros++;
            contador++;
            while(entrada[contador]!='-')//limite del parametro(-parm:x)
            {
                char y2[1];
                y2[0]=entrada[contador];
                strncat(nombreparametro,y2,1);
                contador++;
            }

            if(entrada[contador]=='-'&&entrada[contador+1]=='>'){

                 contador=contador+2;
                 int contadorpar=0;
                 while(nombreparametro[contadorpar])
                 {
                     nombreparametro[contadorpar]=tolower(nombreparametro[contadorpar]);
                     contadorpar++;
                 }
                 //printf("Interprete (1)#:Parametro Reconocido (sin mayusculas)::= %s\n",nombreparametro);

                 char prueba;

                 if(entrada[contador]!='\"')//si no hay comillas en el contenido del parametro
                 {
                     while(entrada[contador]!=' ' && entrada[contador]!='\n' && entrada[contador]!='#' && entrada[contador]!=NULL)
                     {
                     char y3[1];
                     y3[0]=entrada[contador];
                     strncat(parametro,y3,1);
                     contador++;
                     }

                     //printf("Interprete (1)#:Contenido Parametro Sin Comillas= %s\n",parametro);
                     char fn[1];
                     fn[0]='\0';
                     strncat(parametro,fn,1);

                 }else //si existieran comillas en el parametro
                 {
                     char y4[1];
                     y4[0]=entrada[contador];
                     strncat(parametro,y4,1);
                     contador++;
                     while(entrada[contador]!='\"') //&& entrada[contador]!=' ' esto se quita si truena
                     {
                     prueba=entrada[contador];
                     char y5[1];
                     y5[0]=entrada[contador];
                     strncat(parametro,y5,1);

                         contador++;
                     }
                     char y6[1];
                     y6[0]=entrada[contador];
                     strncat(parametro,y6,1);
                     contador++;
                     char fn[1];
                     fn[0]='\0';
                     strncat(parametro,fn,1);
                     //printf("Interprete (1)#:Contenido de Un Parametro con Comillas = %s\n",parametro);
                 }
            }else{

            printf("Interprete (X)#: _ ERROR_1.1 Sintaxis Incorrecta Se Esperaba '->' \n");
            ErrorInterprete++;

            }
            /******************************************************************/
            /*                 Reservadas de Parametros                       */
            /******************************************************************/
            
            if(!strcmp(nombreparametro,"size"))//---------------si reconoce size
            {
             //VAlida Que el SIZE SEA UN NUMERO y mayor a 0
                size=1;
                if(CadenaEsNumero(parametro)==0)
                {
                    nuevafuncion.size=atoi(parametro);
                    //printf("size: %i\n",nuevafuncion.size);

                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);

                }else if(parametro[0]=='-')
                {
                    //parametro++;(aqui se puede cagar esta mierda))
                    if(CadenaEsNumero(parametro)==0)
                    {
                        nuevafuncion.size=atoi(parametro)*-1;
                        //printf("size: %i\n",nuevafuncion.size);
                        limpiarvar(parametro,1000);
                        limpiarvar(nombreparametro,100);
                    }
                }else{
                    printf("\nInterprete (X)#: _ ERROR_1.2: Parametro de 'size' Invalido \n\n");
                    ErrorInterprete++;
                    size=0;
                }                     
            }else
            if(!strcmp(nombreparametro,"path"))//---------------si reconoce path
            {
                //agrega el directorio
                path=1;
                strcpy(nuevafuncion.path,parametro);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);

            }else
            if(!strcmp(nombreparametro,"name"))//------------------reconoce name
            {
                name=1;
                char env[1000];
                strcpy(env,parametro);
                quitarComillas(env);
                strcpy(nuevafuncion.name,sincomillas);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }else
            if(!strcmp(nombreparametro,"unit"))//---------------si reconoce unit
            {
                unit=2;
                //validacion para reconocer solo 'm' y 'k' como dimencionales
                if(parametro[0]=='m' || parametro[0]=='k' || parametro[0]=='b'||parametro[0]=='M' || parametro[0]=='K' || parametro[0]=='B')
                {
                    nuevafuncion.unit=parametro[0];
                    //printf("unit: %c\n",nuevafuncion.unit);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else
                {
                    unit=0;
                    printf("\nInterprete (x)#: _ ERROR_1.7: Parametro de 'unit' Invalido \n\n");
                    ErrorInterprete++;
                }
            }else
            if(!strcmp(nombreparametro,"type"))//------------------reconoce type
            {

                type=2;
                if(parametro[0]=='p' || parametro[0]=='e'  || parametro[0]=='l'||parametro[0]=='P' || parametro[0]=='E'  || parametro[0]=='L'){
                    nuevafuncion.type=parametro[0];
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }else if(!strcmp(parametro,"fast") || !strcmp(parametro,"full")){
                    
                    strcpy(nuevafuncion.typeFormatear,parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else{
                type=0;
                    printf("\nInterprete (X)#: _ ERROR_3.4: Parametro de 'type' Invalido \n\n");
                    ErrorInterprete++;
                }

            }else
            if(!strcmp(nombreparametro,"fit"))//--------------------reconoce fit
            {

                fit=2;
                if(!strcmp(parametro,"bf") || !strcmp(parametro,"ff") || !strcmp(parametro,"wf")||!strcmp(parametro,"BF") || !strcmp(parametro,"FF") || !strcmp(parametro,"WF")  )
                {
                    strcpy(nuevafuncion.fit,parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else
                {
                    fit=0;
                    printf("\nInterprete (X)#: _ ERROR: Parametro de 'fit' Invalido \n\n");
                    ErrorInterprete++;
                }

            }else
            if(!strcmp(nombreparametro,"allocation"))//--------------------reconoce Allocation
            {

                allocation=2;
                if(parametro[0]=='c'  || parametro[0]=='C'  || parametro[0]=='e' || parametro[0]=='E' || !strcmp(parametro,"IX") || !strcmp(parametro,"ix") || !strcmp(parametro,"Ix") || !strcmp(parametro,"iX"))
                {
                    strcpy(nuevafuncion.allocation,parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else
                {
                    allocation=0;
                    printf("\nInterprete (X)#: _ ERROR: Parametro de 'allocation' Invalido \n\n");
                    ErrorInterprete++;
                }
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);

            }else
            if(!strcmp(nombreparametro,"delete"))//--------------reconoce delete
            {
                delete_=2;
                if((!strcmp(parametro,"fast")) || (!strcmp(parametro,"full"))||(!strcmp(parametro,"FULL")) || (!strcmp(parametro,"FAST")) )
                {
                    strcpy(nuevafuncion.delete_,parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else
                {
                    delete_=0;
                    printf("\nInterprete (X)#: _ ERROR_3.5: Parametro de 'delete' Invalido \n\n");
                    ErrorInterprete++;
                }
            }else
            if(!strcmp(nombreparametro,"add"))//--------------------reconoce add
            {

                add=2;
                if(CadenaEsNumero(parametro)==0)
                {
                    nuevafuncion.add=atoi(parametro);
                    limpiarvar(parametro,1000);
                    limpiarvar(nombreparametro,100);
                }
                else if(parametro[0]=='-')
                {
                    if(CadenaEsNumero(parametro)==0)
                    {
                        nuevafuncion.add=atoi(parametro)*-1;
                        limpiarvar(parametro,1000);
                        limpiarvar(nombreparametro,100);
                    }
                }
                else{
                    printf("\nInterprete (X)#: _ ERROR_3.6: Parametro de 'add' Invalido (debe ser numero)\n\n");
                    ErrorInterprete++;
                    add=0;
                }

            }else
            if(!strcmp(nombreparametro,"id"))//---------------si reconoce path
            {   
                id=1;
                strcpy(nuevafuncion.id,parametro);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }
            else
            if(nombreparametro[0]=='i'&&nombreparametro[1]=='d'&&EsNumero(nombreparametro[2])==1){
                
                printf("hola");
                
                idlistado=1;
                strcpy(listaIds[contadorIds].id,parametro);
                contadorIds++;
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            
            }
            else
            if(!strcmp(nombreparametro,"fs"))//--------------------reconoce fs
            {
                fs=1;
                char env[1000];
                strcpy(env,parametro);
                quitarComillas(env);
                strcpy(nuevafuncion.fs,sincomillas);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }else
            if(!strcmp(nombreparametro,"contenido"))//------------------reconoce name
            {
                contenido=1;
                char env[1000];
                //strcpy(env,parametro);
                //quitarComillas(env);
                strcpy(nuevafuncion.Contenido,parametro);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }else
            if(!strcmp(nombreparametro,"fileid"))//------------------reconoce name
            {
                fileid=1;
                idlistado2=1;
                strcpy(listaIds2[contadorIds2].id,parametro);
                contadorIds2++;
                //strcpy(nuevafuncion.fileid,parametro);
                limpiarvar(parametro,1000);
                limpiarvar(nombreparametro,100);
            }
            else{
            printf("\nInterprete (X)#: _ ERROR_1.5: Parametro obligatorio Invalido \n\n");
            ErrorInterprete++;
            }
            
        }
        else if(entrada[contador]=='\n'){
            
            contador++;
            //printf("Reconocido: SAlto Linea::::::\n");
            

            if(!strcmp(instruccion,"mount") && name==0 && path==0){
                    
                activarmount=1;
                              
            }

            if((entrada[contador]=='%'||entrada[contador]=='&')){

            }else{
                
                if(ErrorInterprete==0 && fin==0){
                    
                    if(instruccion!=NULL||instruccion[0]!='\0'){
                        
                        if(!strcmp(instruccion,"exec")){//******************EXEC

                            printf("\n-----------------------------------------------------------------------\n");
                            printf("/******************Ejecutando COMANDO...****************************/\n");
                            printf("-----------------------------------------------------------------------\n\n");

                            ContadorInstrucciones++;//cuenta las intrucciones encontradas
                            if(path==1)
                            {
                                printf("\n\n Ejecutar Script... \n\n");
                                //--------------------------------------------------------Ejecutar Script
                                char *f=LeerScript(nuevafuncion.path);
                                printf("\n\n La Cadena Final es:  %s \n\n",f);

                               Interprete(f);
                               limpiarvar(instruccion,100);


                            }else{
                                printf("\nInterprete (X)#:_ ERROR_1.6: Ingrese todos los parametros obligatorios de 'exec'\n\n");
                                ErrorComando++;
                            }
                        //FIN DEL EXEC
                        }else if(!strcmp(instruccion,"mkdisk")){//**********MKDISK

                                printf("\n-----------------------------------------------------------------------\n");
                                printf("/******************Ejecutando COMANDO...****************************/\n");
                                printf("-----------------------------------------------------------------------\n\n");

                                if(unit==0){
                                    printf("Colocando unit Aleatoria...\n");
                                    nuevafuncion.unit='m';
                                }else{

                                    if(nuevafuncion.unit=='b'){
                                        printf("\nInterprete (X)#: _ ERROR2: Parametros 'mkdisk' Invalidos\n\n");
                                        printf("Recolocando dimencional en MB \n");
                                        nuevafuncion.unit='m';
                                    }else{
                                    }
                                }

                                if(unit==0 && numeroparametros==3   && path==1 && name==1 && size==1)
                                {
                                    printf("Creando disco... ^_^ \n\n");
                                    //----------------------------------------------------------CrearArchivo(nuevafuncion);
                                    CrearDisco(nuevafuncion);
                                    limpiarvar(instruccion,100);

                                }
                                else if(unit==2 && numeroparametros==4   && path==1 && name==1 && size==1)
                                {
                                    printf("Creando disco... ^_^ \n\n");
                                    //----------------------------------------------------------CrearArchivo(nuevafuncion);
                                    CrearDisco(nuevafuncion);
                                    limpiarvar(instruccion,100);

                                }
                                else
                                {
                                    printf("\nInterprete (X)#: _ ERROR_2.2: Parametros 'mkdisk' Invalidos\n\n");
                                    ErrorComando++;
                                }

                                ContadorInstrucciones++;
                                limpiarvar(instruccion,100);

                        }//FIN DEL ,MKDISK
                            else if(!strcmp(instruccion,"rmdisk")){//***********RMDISK
                                ContadorInstrucciones++;
                                if(path==1&&numeroparametros==1){

                                    int opcion;
                                    printf("%s\n", "(!)-¿Desea eliminar este Disco?");
                                    printf("%s\n", "1-Si");
                                    printf("%s\n", "2-no");

                                    printf("%s\n", "");
                                    printf(">>>>:~$ ");
                                    scanf("%d",&opcion);

                                    if(opcion>0 && opcion<3){

                                        switch(opcion)
                                        {
                                            case 1:

                                                printf("Eliminando disco...\n");
                                                //------------------------------------------------------EliminarDisco(nuevafuncion);
                                                EliminarDisco(nuevafuncion);
                                                limpiarvar(instruccion,100);

                                            break;
                                            case 2:
                                                printf("*******OPERACION CANCELADA*********\n");
                                            break;
                                            default:
                                                printf("Error FATAL \n");
                                            break;
                                        }
                                    }else
                                    {
                                        opcion=1;
                                        printf(" \n");
                                        printf("%s\n", ">>>> Error De Seleccion <<<< ");

                                    }

                                }else{
                                    printf("\nInterprete (X)#:_ ERROR_3.1: Parametros 'rmdisk' Invalidos\n\n");
                                    ErrorComando++;
                                }


                        }//FIN DEL RMDISK
                        else if(!strcmp(instruccion,"fdisk")){//------------FDISK

                            printf("\n-----------------------------------------------------------------------\n");
                            printf("/******************Ejecutando COMANDO...****************************/\n");
                            printf("-----------------------------------------------------------------------\n\n");

                            ContadorInstrucciones++;
                            if(path==1 && name==1)
                            {
                                if(unit==0){
                                    printf("Colocando unit Aleatoria...\n");
                                    nuevafuncion.unit='k';
                                }
                                if(type==0){
                                    printf("Colocando type Aleatorio...\n");
                                    nuevafuncion.type='p';
                                }
                                if(fit==0){
                                    printf("Colocando fit Aleatorio...\n");
                                    strcpy(nuevafuncion.fit,"wf");
                                }
                                if(allocation==0){
                                    printf("Colocando allocation Aleatorio...\n");
                                    strcpy(nuevafuncion.allocation,"IX");
                                }

                                if((add==1 && delete_==1)||(add==2 && delete_==2)||(add==1 && delete_==2)||(add==2 && delete_==1))
                                {
                                    printf("\nInterprete (X)#: _ ERROR_3.2: Parametros 'fdisk' Invalidos(add y delete estan juntos)\n\n");
                                    ErrorComando++;
                                }else if(add==2 && delete_==0 || add==1 && delete_==0){//---------AUMENTAR TAMAÑO
                                    printf("Reducir o Aumentar...\n");
                                    if(add==2){// agrega espacio
                                        printf("Aumentar...\n");
                                        AgregarEspacio(nuevafuncion);
                                    }else
                                    if(add==1){ //quita espacio
                                        printf("Quitar...\n");
                                        QuitarEspacio(nuevafuncion);
                                    }else{
                                    printf("\nInterprete (X)#: _ ERROR_7.3: Parametros 'fdisk' Invalidos(en el ADD)\n\n");
                                    ErrorComando++;
                                    }
                                    //------------------------------------------------------Reducir o Aumentar
                                    limpiarvar(instruccion,100);
                                }else if(add==0 && delete_==2){//_--------ELIMINAR PARTICION

                                    if(nuevafuncion.type=='p' || nuevafuncion.type=='e'||nuevafuncion.type=='P' || nuevafuncion.type=='E')
                                    {

                                        int opcion;
                                        printf("%s\n", "(!)-¿Desea eliminar esta Particion?");
                                        printf("%s\n", "1-Si");
                                        printf("%s\n", "2-no");

                                        printf("%s\n", "");
                                        printf(">>>>:~$ ");
                                        scanf("%d",&opcion);

                                        if(opcion>0 && opcion<3){

                                            switch(opcion)
                                            {
                                            case 1:
                                            //-----------------------------------------------EliminarParticion(funcion);
                                            printf("Eliminar Particion...\n");
                                            EliminarParticion(nuevafuncion);
                                            limpiarvar(instruccion,100);
                                            break;
                                            case 2:
                                                printf("*******OPERACION CANCELADA*********\n");
                                            break;
                                            default:
                                                printf("Error FATAL \n");
                                            break;
                                            }
                                        }else
                                        {
                                            opcion=1;
                                            printf(" \n");
                                            printf("%s\n", ">>>> Error De Seleccion <<<< ");
                                        }

                                    }
                                    else
                                    {
                                        //--------------------------------------------------EliminarParticionLogica(funcion);
                                        printf("Eliminar Particion Logica...\n");
                                        limpiarvar(instruccion,100);
                                    }

                                }else if (add==0 && delete_==0 && size==1){//---Crear Particion

                                    if(nuevafuncion.type=='p' ||  nuevafuncion.type=='e'||nuevafuncion.type=='P' ||  nuevafuncion.type=='E')
                                    {
                                        printf("Creando Particion...\n\n");
                                        //--------------------------------------------------CrearParticion(nuevafuncion);
                                        CrearParticion(nuevafuncion);
                                        limpiarvar(instruccion,100);

                                    }
                                    else
                                    {
                                         printf("Creando Particion Logican...\n");
                                        //--------------------------------------------------CrearParticionLogica(nuevafuncion);
                                         CrearParticionLogica(nuevafuncion);
                                         limpiarvar(instruccion,100);

                                    }

                                }else{
                                    printf("\nInterprete (X)#: _ ERROR_3.3: Parametros 'fdisk' Invalidos(*)\n\n");
                                    ErrorComando++;

                                }


                            }else{
                                printf("\nInterprete (X)#: _ ERROR_3.2: Parametros Obligatorios del 'fdisk'\n\n");
                                ErrorComando++;
                            }

                        }//fin del FDISK
                        else if(!strcmp(instruccion,"lspart")){
            
                             //-------------------------------------------------------------LSPART
                            if(path==1)
                            {                                                                             
                                printf("\n\n Informacion ls \n\n");
                                ls(nuevafuncion);
                                limpiarvar(instruccion,100);

                            }else{
                                printf("\n\nInterprete (X)#: _ ERROR8: Ingrese todos los parametros obligatorios de 'ls'\n\n");
                                ErrorComando++;
                            }
            
                        }//fin LSPART    
                        else if(!strcmp(instruccion,"mount")){//---------------------------------Ejecuta El Mount
            
                            if(path==1 && name==1)
                            {

                                printf("Montar Particion...\n\n");
                                MontarParticionF1(nuevafuncion);
                                limpiarvar(instruccion,100);

                            }else if(activarmount==1 || (path==0 && name==0)){


                                printf("\nLISTAR MONTADAS......\n");
                                MostrarMontadas();
                                activarmount=0;
                                name=5;
                                path=5;
                                limpiarvar(instruccion,100);
                                ContadorComandosExitosos++;
                                printf("\n:::::::::::::::::: FIN LISTA DE MONTADAS :::::::::::::::::::::::::\n\n");

                            }else{

                                printf("\n\nInterprete (X)#: _ ERROR_5.1: Ingrese todos los parametros obligatorios de 'mount'\n\n");
                                ErrorComando++;
                                //MostrarMontadas();

                            }
                        }// fin mount
                        else if(!strcmp(instruccion,"unmount")){//---------------------------------Ejecuta El unmount
                
                            if(id==1){

                                printf("Desmontar Particion...\n\n");
                                printf("Imprime El PArametro:... %s\n\n",nuevafuncion.id);
                                DesmontarParticion(nuevafuncion);//-------------------------Desmontar
                                limpiarvar(instruccion,100);

                            }else if(idlistado==1){

                                printf("Desmontar Particion LISTADO...\n\n");
                                int j=0;
                                for(j=0; j<contadorIds; j++){    

                                    limpiarvar(nuevafuncion.id,100);
                                    strcpy(nuevafuncion.id,listaIds[j].id);
                                    printf("Desmontando Particion...%s\n\n",nuevafuncion.id);
                                    DesmontarParticion(nuevafuncion);//-------------------------Desmontar    
                                }

                                contadorIds=0;
                                int i=0;
                                for(i=0; i<20; i++){    
                                 limpiarvar(listaIds[i].id,100);            
                                }

                            }
                            else{
                            printf("\n\nInterprete (X)#: _ ERROR_5.9: Ingrese todos los parametros obligatorios de 'unmount'\n\n");
                            ErrorComando++;
                            }
                        }//FIN UMOUNT
                        else if (!strcmp(instruccion,"rep")){//-----------------REPORTES
                
                
                            if(path==1 && name==1 && id==1){

                                   //REVISA Q TIPO DE REPORTE ES

                                if(!strcmp(nuevafuncion.name,"mbr")){  //reporte mbr

                                    printf("\nREPORTE DE MBR... %s\n\n",nuevafuncion.path);
                                    ReporteMBR_dot(nuevafuncion);
                                    limpiarvar(instruccion,100);

                                }else if(!strcmp(nuevafuncion.name,"disk")){  //report disk

                                    printf("\nREPORTE DE DISK...\n\n");
                                    ReporteDiskMBR(nuevafuncion);
                                    limpiarvar(instruccion,100);
                                    
                                }else if(!strcmp(nuevafuncion.name,"bm_block")){  //report block
                                    
                                    printf("\nREPORTE DE BM_BLOCK...\n\n");
                                    Reporte_bm_Block(nuevafuncion);
                                    limpiarvar(instruccion,100);

                                }else if(!strcmp(nuevafuncion.name,"block")){  //report block
                                    
                                    printf("\nREPORTE DE BLOCK...\n\n");
                                    Reporte_Block(nuevafuncion);
                                    limpiarvar(instruccion,100);

                                }
                                else{
                                    printf("\n\nInterprete (X)#: _ ERROR_5.5: EL Parametro 'name' es Invalido\n\n");
                                    ErrorComando++;
                                }     

                            }else{
                            printf("\n\nInterprete (X)#: _ ERROR_5.6: Ingrese todos los parametros obligatorios de 'rep'\n\n");
                            ErrorComando++;
                            }
                    
                        }//FIN DE REPORTES
                        else if (!strcmp(instruccion,"mkfs")){//*********************************mkfs
                

                        if(id==1){

                            if(unit==0){
                                printf("Colocando unit Aleatoria...\n");
                                nuevafuncion.unit='k';
                            }
                            if(type==0){
                                printf("Colocando type Aleatorio...\n");
                                strcpy(nuevafuncion.typeFormatear,"full");
                            }
                            if(fs==0){
                                printf("Colocando FS Aleatorio...\n");
                                strcpy(nuevafuncion.fs,"EC");
                            }
                            
                            Formatear(nuevafuncion);
                            limpiarvar(instruccion,100);

                        }else{
                        printf("\nInterprete (X)#: _ ERROR_10.2: Ingrese todos los parametros obligatorios de 'mkfs'\n\n");
                        ErrorComando++;
                        }

                        }//fin de mkfs 
                        else if (!strcmp(instruccion,"mkfile")){//**************Mkfile
                                if(id==1 && name==1 && contenido==1){
                                    printf("MKFILE CREAR ARCHIVOS...\n\n");
                                    CrearArchivo(nuevafuncion);
                                    limpiarvar(instruccion,100);
                                    
                                }else{
                                printf("\nInterprete (X)#: _ ERROR_10.1: Ingrese todos los parametros obligatorios de 'mkfile'\n\n");
                                ErrorComando++;
                                }
                        }//fin de mkfile
                        else if (!strcmp(instruccion,"rmfile")){//**************RM

                            if(id==1 && fileid==1){

                                printf("Eliminar Archivo LISTADO...\n\n");
                                int j=0;
                                for(j=0; j<contadorIds2; j++){    

                                    limpiarvar(nuevafuncion.fileid,100);
                                    strcpy(nuevafuncion.fileid,listaIds2[j].id);
                                    printf("Eliminar Archivo Listado...%s\n\n",nuevafuncion.fileid);
                                    EliminarArchivo(nuevafuncion);  

                                }

                                contadorIds2=0;
                                int i=0;
                                for(i=0; i<20; i++){    
                                 limpiarvar(listaIds2[i].id,100);            
                                }
                                
                                limpiarvar(instruccion,100);
                                }else{
                                printf("\n\nInterprete (X)#: _ ERROR_5.9: Ingrese todos los parametros obligatorios de 'Fileid'\n\n");
                                ErrorComando++;
                                }

                        }//fin de rmfile     
                        }else{
                            printf("\n\n-------------------------------------------------------------No Hay Instruccion\n\n");
                        }
                    
                }else{
                    printf("\n (*) Errores Encontrados En Interprete : '%i' \n", ErrorInterprete);
                    printf("**************************************************************************\n");
                    printf("***********  Existen Errores En La Sintaxis ******************************\n");
                    printf("**************************************************************************\n\n");
                }
                
            }
            
            
        }//FIN SALTO DE LINEA
        else{ //--------------------------------------SEGUIR AVANZANDO LA CADENA
            contador++;
        }
        
        
    }//fin while 1 Analizador 
    
    printf("\n (*) Errores Encontrados En Interprete : '%i' \n", ErrorInterprete);
    printf("**************************** FIN INSTRUCCION ******************************\n");



    /*////////////////////////////////////////////////////////////////////////*/
    /***********************VALIDAR CRACIONES**********************************
    /*////////////////////////////////////////////////////////////////////////*/

    if(ErrorInterprete==0 && fin==0){
        
        if(instruccion!=NULL||instruccion[0]!='\0'){
            
            if(!strcmp(instruccion,"exec")){//**************************************exec

            printf("\n-----------------------------------------------------------------------\n");
            printf("/******************Ejecutando COMANDO...****************************/\n");
            printf("-----------------------------------------------------------------------\n\n");

            ContadorInstrucciones++;
            if(path==1)
            {
                printf("\n\n Ejecutar Script... \n\n");
                //--------------------------------------------------------Ejecutar Script
                char *f=LeerScript(nuevafuncion.path);
                printf("\n\n La Cadena Final es:  %s \n\n",f);

                Interprete(f);
                limpiarvar(instruccion,100);


            }else{
                printf("\nInterprete (X)#: _ ERROR_1.6: Ingrese todos los parametros obligatorios de 'exec'\n\n");
                ErrorComando++;
            }
        }//Fin Exec
        else if(!strcmp(instruccion,"mkdisk")){//*******************************mkdisk

            printf("\n-----------------------------------------------------------------------\n");
            printf("/******************Ejecutando COMANDO...****************************/\n");
            printf("-----------------------------------------------------------------------\n\n");

            if(unit==0){
                printf("Colocando unit Aleatoria...\n");
                nuevafuncion.unit='m';
            }else{

                if(nuevafuncion.unit=='b'){
                    printf("\nInterprete #_ ERROR2: Parametros 'mkdisk' Invalidos\n\n");
                    printf("Recolocando dimencional en MB \n");
                    nuevafuncion.unit='m';
                }else{
                }
            }

            if(unit==0 && numeroparametros==3   && path==1 && name==1 && size==1)
            {
                printf("Creando disco... ^_^ \n\n");
                //----------------------------------------------------------CrearArchivo(nuevafuncion);
                CrearDisco(nuevafuncion);
                limpiarvar(instruccion,100);

            }
            else if(unit==2 && numeroparametros==4   && path==1 && name==1 && size==1)
            {
                printf("Creando disco... ^_^ \n\n");
                //----------------------------------------------------------CrearArchivo(nuevafuncion);
                CrearDisco(nuevafuncion);
                limpiarvar(instruccion,100);

            }
            else
            {
                printf("\nInterprete (X)#: _ ERROR_2.2: Parametros 'mkdisk' Invalidos\n\n");
                ErrorComando++;
            }

            ContadorInstrucciones++;
            limpiarvar(instruccion,100);
        }//fin del mkdisk
        else if(!strcmp(instruccion,"rmdisk")){//*******************************rmdisk
            ContadorInstrucciones++;
            if(path==1&&numeroparametros==1){
            int opcion;
            printf("%s\n", "(!)-¿Desea eliminar este Disco?");
            printf("%s\n", "1-Si");
            printf("%s\n", "2-no");

            printf("%s\n", "");
            printf(">>>>:~$ ");
            scanf("%d",&opcion);

            if(opcion>0 && opcion<3){

                switch(opcion)
                {
                    case 1:

                        printf("Eliminando disco...\n");
                        //------------------------------------------------------EliminarDisco(nuevafuncion);
                        EliminarDisco(nuevafuncion);
                        limpiarvar(instruccion,100);

                    break;
                    case 2:
                        printf("*******OPERACION CANCELADA*********\n");
                    break;
                    default:
                        printf("Error FATAL \n");
                    break;
                }
            }else
            {
             opcion=1;
             printf(" \n");
             printf("%s\n", ">>>> Error De Seleccion <<<< ");

            }

        }else{
            printf("\nInterprete (X)#: _ ERROR_3.1: Parametros 'rmdisk' Invalidos\n\n");
            ErrorComando++;
        }
        }//fin del rmdisk 
        else if(!strcmp(instruccion,"fdisk")){//--------------------------------fdisk

            printf("\n-----------------------------------------------------------------------\n");
            printf("/******************Ejecutando COMANDO...****************************/\n");
            printf("-----------------------------------------------------------------------\n\n");

            ContadorInstrucciones++;
            if(path==1 && name==1)
            {
                if(unit==0){
                    printf("Colocando unit Aleatoria...\n");
                    nuevafuncion.unit='k';
                }
                if(type==0){
                    printf("Colocando type Aleatorio...\n");
                    nuevafuncion.type='p';
                }
                if(fit==0){
                    printf("Colocando fit Aleatorio...\n");
                    strcpy(nuevafuncion.fit,"wf");
                }
                if(allocation==0){
                    printf("Colocando allocation Aleatorio...\n");
                    strcpy(nuevafuncion.allocation,"IX");
                }

                if((add==1 && delete_==1)||(add==2 && delete_==2)||(add==1 && delete_==2)||(add==2 && delete_==1))
                {
                    printf("\nInterprete (X)#: _ ERROR_3.2: Parametros 'fdisk' Invalidos(add y delete estan juntos)\n\n");
                    ErrorComando++;
                }else if(add==2 && delete_==0||add==1 && delete_==0){//---------AUMENTAR TAMAÑO
                    printf("Reducir o Aumentar...\n");
                                        
                    if(add==2){// agrega espacio
                        printf("Aumentar...\n");
                        AgregarEspacio(nuevafuncion);
                    }else
                    if(add==1){ //quita espacio
                        printf("Quitar...\n");
                        QuitarEspacio(nuevafuncion);

                    }else{
                    printf("\nInterprete (X)#: _ ERROR_7.3: Parametros 'fdisk' Invalidos(en el ADD)\n\n");
                    ErrorComando++;
                    }
                    //------------------------------------------------------Reducir o Aumentar
                    //------------------------------------------------------Reducir o Aumentar
                    limpiarvar(instruccion,100);
                }else if(add==0 && delete_==2){//_--------ELIMINAR PARTICION

                    if(nuevafuncion.type=='p' || nuevafuncion.type=='e'||nuevafuncion.type=='P' || nuevafuncion.type=='E')
                    {

                        int opcion;
                        printf("%s\n", "(!)-¿Desea eliminar esta Particion?");
                        printf("%s\n", "1-Si");
                        printf("%s\n", "2-no");

                        printf("%s\n", "");
                        printf(">>>>:~$ ");
                        scanf("%d",&opcion);

                        if(opcion>0 && opcion<3){

                            switch(opcion)
                            {
                            case 1:
                            //-----------------------------------------------EliminarParticion(funcion);
                            printf("Eliminar Particion...\n");
                            EliminarParticion(nuevafuncion);
                            limpiarvar(instruccion,100);
                            break;
                            case 2:
                                printf("*******OPERACION CANCELADA*********\n");
                            break;
                            default:
                                printf("Error FATAL \n");
                            break;
                            }
                        }else
                        {
                            opcion=1;
                            printf(" \n");
                            printf("%s\n", ">>>> Error De Seleccion <<<< ");
                        }

                    }
                    else
                    {
                        //--------------------------------------------------EliminarParticionLogica(funcion);
                        printf("Eliminar Particion Logica...\n");
                        limpiarvar(instruccion,100);
                    }

                }else if (add==0 && delete_==0 && size==1){//---Crear Particion

                    if(nuevafuncion.type=='p' ||  nuevafuncion.type=='e'||nuevafuncion.type=='P' ||  nuevafuncion.type=='E')
                    {
                        printf("Creando Particion...\n\n");
                        //--------------------------------------------------CrearParticion(nuevafuncion);
                        CrearParticion(nuevafuncion);
                        limpiarvar(instruccion,100);

                    }
                    else
                    {
                         printf("Creando Particion Logican...\n");
                        //--------------------------------------------------CrearParticionLogica(nuevafuncion);
                         CrearParticionLogica(nuevafuncion);
                         limpiarvar(instruccion,100);

                    }

                }else{
                    printf("\nInterprete (X)#: _ ERROR_3.3: Parametros 'fdisk' Invalidos(*)\n\n");
                    ErrorComando++;

                }


            }else{
                printf("\nInterprete (X)#: _ ERROR_3.2: Parametros Obligatorios del 'fdisk'\n\n");
                ErrorComando++;
            }

        }//fin del fdisk    
        else if(!strcmp(instruccion,"lspart")){

                 //-------------------------------------------------------------Info
            if(path==1)
            {                                                                             
                printf("\n\n Informacion ls \n\n");
                ls(nuevafuncion);
                limpiarvar(instruccion,100);

            }else{
                printf("\n\nInterprete (X)#: _ ERROR8: Ingrese todos los parametros obligatorios de 'ls'\n\n");
                ErrorComando++;
            }

        }//fin lspart
        else if(!strcmp(instruccion,"mount")){//---------------------------------Ejecuta El Mount
            
                if(path==1 && name==1)
                {

                    printf("Montar Particion...\n\n");
                    MontarParticionF1(nuevafuncion);
                    limpiarvar(instruccion,100);

                }else if(activarmount==1 || (path==0 && name==0)){


                    printf("\nLISTAR MONTADAS......\n");
                    MostrarMontadas();
                    activarmount=0;
                    name=5;
                    path=5;
                    limpiarvar(instruccion,100);
                    ContadorComandosExitosos++;
                    printf("\n:::::::::::::::::: FIN LISTA DE MONTADAS :::::::::::::::::::::::::\n\n");

                }else{

                    printf("\n\nInterprete (X)#: _ ERROR_5.1: Ingrese todos los parametros obligatorios de 'mount'\n\n");
                    ErrorComando++;
                    //MostrarMontadas();

                }
        }// fin mount
        else if(!strcmp(instruccion,"unmount")){//---------------------------------Ejecuta El unmount
                
                if(id==1){

                    printf("Desmontar Particion...\n\n");
                    printf("Imprime El PArametro:... %s\n\n",nuevafuncion.id);
                    DesmontarParticion(nuevafuncion);//-------------------------Desmontar
                    limpiarvar(instruccion,100);

                }else if(idlistado==1){

                    printf("Desmontar Particion LISTADO...\n\n");
                    int j=0;
                    for(j=0; j<contadorIds; j++){    

                        limpiarvar(nuevafuncion.id,100);
                        strcpy(nuevafuncion.id,listaIds[j].id);
                        printf("Desmontando Particion...%s\n\n",nuevafuncion.id);
                        DesmontarParticion(nuevafuncion);//-------------------------Desmontar 
                        
                    }

                    contadorIds=0;
                    int i=0;
                    for(i=0; i<20; i++){    
                     limpiarvar(listaIds[i].id,100);            
                    }
                    limpiarvar(instruccion,100);
                }
                else{
                printf("\n\nInterprete (X)#: _ ERROR_5.9: Ingrese todos los parametros obligatorios de 'unmount'\n\n");
                ErrorComando++;
                }
        }//FIN UMOUNT
        else if (!strcmp(instruccion,"rep")){//*********************************reportes
                
                
                if(path==1 && name==1 && id==1){

                       //REVISA Q TIPO DE REPORTE ES

                    if(!strcmp(nuevafuncion.name,"mbr")){  //reporte mbr

                        printf("\nREPORTE DE MBR... %s\n\n",nuevafuncion.path);
                        ReporteMBR_dot(nuevafuncion);
                        limpiarvar(instruccion,100);

                    }else if(!strcmp(nuevafuncion.name,"disk")){  //report disk

                        printf("\nREPORTE DE DISK...\n\n");
                        ReporteDiskMBR(nuevafuncion);
                        limpiarvar(instruccion,100);
                    }else if(!strcmp(nuevafuncion.name,"bm_block")){  //report block
                                    
                        printf("\nREPORTE DE BM_BLOCK...\n\n");
                        Reporte_bm_Block(nuevafuncion);
                        limpiarvar(instruccion,100);

                    }else if(!strcmp(nuevafuncion.name,"block")){  //report block
                                    
                        printf("\nREPORTE DE BLOCK...\n\n");
                        Reporte_Block(nuevafuncion);
                        limpiarvar(instruccion,100);

                    }
                    else{
                        printf("\nInterprete (X)#: _ ERROR_5.5: EL Parametro 'name' es Invalido\n\n");
                        ErrorComando++;
                    }     

                }else{
                printf("\nInterprete (X)#: _ ERROR_5.6: Ingrese todos los parametros obligatorios de 'rep'\n\n");
                ErrorComando++;
                }
                    
        }//fin de los reportes
        else if (!strcmp(instruccion,"mkfs")){//*********************************Mkfs
                
                
                if(id==1){
                    
                    if(unit==0){
                        printf("Colocando unit Aleatoria...\n");
                        nuevafuncion.unit='k';
                    }
                    if(type==0){
                        printf("Colocando type Aleatorio...\n");
                        strcpy(nuevafuncion.typeFormatear,"full");
                    }
                    if(fs==0){
                        printf("Colocando FS Aleatorio...\n");
                        strcpy(nuevafuncion.fs,"EC");
                    }
    
                    Formatear(nuevafuncion);
                    limpiarvar(instruccion,100);
                    
                }else{
                printf("\nInterprete (X)#: _ ERROR_10.1: Ingrese todos los parametros obligatorios de 'mkfs'\n\n");
                ErrorComando++;
                }
                    
        }//fin de mkfs 
        else if (!strcmp(instruccion,"mkfile")){//*********************************Mkfile
                if(id==1 && name==1 && contenido==1){
                    printf("MKFILE CREAR ARCHIVOS...\n\n");
                    CrearArchivo(nuevafuncion);
                    limpiarvar(instruccion,100);
                }else{
                printf("\nInterprete (X)#: _ ERROR_10.1: Ingrese todos los parametros obligatorios de 'mkfile'\n\n");
                ErrorComando++;
                }
        }//fin de mkfile
        else if (!strcmp(instruccion,"rmfile")){//**************RM

                if(id==1 && fileid==1){

                    printf("Eliminar Archivo LISTADO...\n\n");
                    int j=0;
                    for(j=0; j<contadorIds2; j++){    
   
                        limpiarvar(nuevafuncion.fileid,100);
                        strcpy(nuevafuncion.fileid,listaIds2[j].id);
                        printf("Eliminar  Archivo Lista...%s\n\n",nuevafuncion.fileid);
                        EliminarArchivo(nuevafuncion);
                        
                    }

                    contadorIds2=0;
                    int i=0;
                    for(i=0; i<20; i++){    
                     limpiarvar(listaIds2[i].id,100);            
                    }
                    
                    limpiarvar(instruccion,100);
                }else{
                printf("\n\nInterprete (X)#: _ ERROR_5.9: Ingrese todos los parametros obligatorios de 'Fileid'\n\n");
                ErrorComando++;
                }
            
        }//fin de rmfile     
        }else{
            printf("\n\n-------------------------------------------------------------No Hay Instruccion\n\n");
        }
        
    }else{
        printf("\n (*) Errores Encontrados En Interprete : '%i' \n", ErrorInterprete);
        printf("**************************************************************************\n");
        printf("***********  Existen Errores En La Sintaxis ******************************\n");
        printf("**************************************************************************\n\n");
    }
    
    
}


//-------------------------Discos-----------------------------------------------
void CrearDisco(Funcion funcion)
{

    MbrDisco mbr;
    mbr.mbr_tamano=funcion.size;
    time_t tiempo = time(0);
    struct tm *tlocal = localtime(&tiempo);
    char output[128];
    strftime(output,128,"%d/%m/%y %H:%M:%S",tlocal);
    printf("SYSTEM $_ HORA Creacion: %s\n",output);
    int id=funcion.path;
    
    //*******************************VErifica la fecha**************************
    int k=0;
    int l=0;
    for(k=0;k<25;k++)
    {
    mbr.mbr_fecha_creacion[l++]=output[k];
    }
    mbr.mbr_disk_signature=id;
    
    int tamano=0;
    if(funcion.unit=='k'||funcion.unit=='K')
    {
        tamano=funcion.size*1024;
    }
    else
    {
        tamano=funcion.size*(1024*1024);
    }
    
    //valida el multiplo de 8
    int Multiplo;
    int Multiplo8=8;
    
    Multiplo=funcion.size%Multiplo8;
    
    
    //si el tamaño es menor a 8 megas en bytes o no es multiplo de 8 (tamano<8388608 || ))
    if(Multiplo!=0){
        printf("\nInterprete (X)#: _ ERROR_6.6 El Minimo de Tamaño del Disco es de 8mb O EL Size no es Multiplo de 8 :S \n\n");
        ErrorCrearDisco++;
    }else{
    
        //----------------------------------------------------------------------   
        //----------------- Quita "comillas" en la path ------------------------
        //----------------------------------------------------------------------    
        char pathauxiliar[500];
        strcpy(pathauxiliar,funcion.path);
        char finalizado[500];
        strcpy(finalizado,"cd /\n");
        if(pathauxiliar[0]=='\"')
        {
            limpiarvar(funcion.path,100);
            int q=1;
            while(pathauxiliar[q]!='\"')
            {
                char c2[1];
                c2[0]=pathauxiliar[q];
                strncat(funcion.path,c2,1);
                q++;
            }

        }
        //----------------------------------------------------------------------
        //---------------------- Quita "comillas" al name-----------------------
        //----------------------------------------------------------------------
        char pathauxiliar2[500];
        strcpy(pathauxiliar2,funcion.name);

        char finalizado2[500];
        strcpy(finalizado2,"cd /\n");
        if(pathauxiliar2[0]=='\"')
        {
            limpiarvar(funcion.name,100);
            int q=1;
            while(pathauxiliar2[q]!='\"')
            {
                char c2[1];
                c2[0]=pathauxiliar2[q];
                strncat(funcion.name,c2,1);
                q++;
            }

        }
        //----------------------------------------------------------------------

        //-------------------------------------------------/
        //--Verifica que exista la Extencion --------------/
        //------------------------------------------------/
        int con1=0;
        int valExtencion=0;
        while(funcion.name[con1]!=NULL){

            if(funcion.name[con1]=='.'){

                if(funcion.name[con1+1]=='d'&&funcion.name[con1+2]=='s'&&funcion.name[con1+3]=='k'){
                    valExtencion=1;
                }

            }
            con1++;
        }

        //--------------------------------------------------/
        //concatena el nombre con la path
        strcat(funcion.path,funcion.name);

        if(valExtencion==0){//si la extencion es 0 error 
            printf("\nInterprete (X)#: _ ERROR_2.5 ALCrear Disco La extencion No es Correcta \n\n");
            ErrorCrearDisco++;
        }else{ //si la extencion es = 1 

            //------------------------------------------------------------------
            //Para crear Carpetas en los Directorios si estos no an sido Creados
            //------------------------------------------------------------------
            int indice=0;
            char carpeta[500];

            while(funcion.path[indice]!='.')
            {
                if(funcion.path[indice]!='/')
                {
                    //carpeta=ConcatenarCadenaCaracter(carpeta,pathoriginal[indice]);
                    char c1[1];
                    c1[0]=funcion.path[indice];
                    strncat(carpeta,c1,1);
                }
                else
                {
                    strcat(finalizado,"mkdir ");
                    strcat(finalizado,"\"");
                    strcat(finalizado,carpeta);
                    strcat(finalizado,"\"");
                    strcat(finalizado,"\n");
                    strcat(finalizado,"cd ");
                    strcat(finalizado,"\"");
                    strcat(finalizado,carpeta);
                    strcat(finalizado,"\"");
                    strcat(finalizado,"\n");
                    strcat(carpeta,"");
                    limpiarvar(carpeta,500);

                }
                indice++;
            }

            printf("\nImprimir el comando q ejecuta en la terminal si el directorio no existe: %s\n",finalizado);

            system(finalizado);

            //------------------------------------------------------------------
            //------------------------------------------------------------------
            
            //------------------------------------------------------------------
            //-------Aqui  La lectura y Escritura en el Archivo-----------------
            //------------------------------------------------------------------
            
            //Creacion De Archivo que simula el Disco y llenando con \0
            FILE* archivo= fopen(funcion.path, "ab");
            if (archivo==NULL)
            {
                printf("\nInterprete (X)#: _ ERROR_2.3_: Al tratar de Acceder al Archivo \n\n");
                ErrorCrearDisco++;
                //fclose(archivo);
            }
            else
            {
                int fin=(tamano/1024);
                char buffer[1024];
                int i=0;
                for(i=0;i<1024;i++){
                buffer[i]='\0';
                }
                int j=0;
                while(j!=fin){
                fwrite(&buffer,1024 , 1, archivo);
                j++;
                }
                fclose(archivo);
            }
            //Fin Creacion de Archivo 
            
            //Estableciendo propiedades de la estructura del Mbr del disco
            mbr.mbr_tamano=tamano;
            int i;
            for(i=0;i<4;i++)//recorre el arreglo de las 4 particiones
            {//estableciendo datos por defecto
                mbr.particiones[i].part_start=-1;
                mbr.particiones[i].part_status='d';
                mbr.particiones[i].part_size=0;
            }
            
            //abriendo el Archivo qe simula el disco virtual
            FILE* file= fopen(funcion.path, "rb+");
            fseek(file,0,SEEK_SET);// estableciendo puntero al inicio

            if (file==NULL)//si el archivo no contiene nada
            {
                printf("\nInterprete (X)#: _ ERROR_2.4 Al tratar de Acceder al Archivo file \n\n");
                ErrorCrearDisco++;
                //fclose(file);
            }
            else
            {
                fwrite(&mbr, sizeof(MbrDisco), 1, file);//escribiendo la estructura del MBR
                fclose(file);
                printf("\n********************************************************\n");
                printf("---'DISCO CREADO CON EXITO'--- ^_^ '%s'\n",funcion.name);
                printf("\n********************************************************\n");
                ContadorComandosExitosos++;
            }

        }// fin del if de verificacion de extencion
        
    }//Fin de If de Tamaño y multiplo de 8
    
}

void EliminarDisco(Funcion funcion){
    
    //----------------------------------------------------------------------   
    //----------------- Quita "comillas" en la path ------------------------
    //----------------------------------------------------------------------    
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);
    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
    
    FILE *fichero;
    fichero = fopen(funcion.path, "r" );    /* El fichero ha de existir primeramente */
    if(fichero != NULL)
    {
        fclose(fichero);
        if(remove(funcion.path) == 0) {

            printf("\n************************************************************\n");
            printf( "---'DISCO ELIMINADO CON EXITO'--%s :S\n",funcion.path );
            printf("\n************************************************************\n");
            ContadorComandosExitosos++;
        }
        else{
            printf( "\nInterprete (X)#: _ ERROR_2.8 El Archivo no pudo ser eliminado...\n" );
            ErrorEliminarDisco++;
        }
    }
    else {
        printf( "Interprete (X)#: _ ERROR_2.9_: El archivo no fue encontrado...\n" );
        ErrorEliminarDisco++;
        //fclose(fichero);
    }
    
}



//-------------------------Particiones------------------------------------------
void CrearParticion(Funcion funcion){
    //------------------- Quita "comillas" en la path --------------------------
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
    //--------------------------------------------------------------------------
    
    int nombresiguales=0;
    int numeroprimarias=0;
    int numeroextendida=0;

    int TempPrimarias=0;
    int TempExt=0;
    
    //--------------------------INICIO DE CREACION------------------------------
    FILE* file2= fopen(funcion.path, "rb+");
    
    if (file2==NULL){ //si no existe el archivo
        printf("\nInterprete (X)#: _ ERROR_3.7 Al tratar de Acceder al Archivo \n\n");
        ErrorCrearParticionPrimaria++;
            //Aqui Va el Error Crear PArticion Logica
    }else{//si existe
        
        MbrDisco mbr2;
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        //------------------------IMPRIMIR DATOS DEL DISCO----------------------
        printf("-----------CrearParticion Datos Del Disco--------------------\n");
        printf("%i",mbr2.mbr_disk_signature);
        printf("\n");
        printf(mbr2.mbr_fecha_creacion);
        printf("\n");
        printf("Tamaño %i",mbr2.mbr_tamano);
        printf("-----------INICIALMENTE Primarias----------------------------\n");

        //------------------------Recorrido De PArticiones----------------------
        
        int z=0;
        for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
            int k=0;
            int l=0;
            while(funcion.name[k]!=NULL){
            if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                l++;
            }
                k++;
            }
            if(l==k && mbr2.particiones[z].part_status!='0'){// si las coincidencias son iguales y el status 0
                nombresiguales=1;
                printf("\nInterprete (X)#: _ ERROR_3.8* Pariciones iguales  %i \n\n",nombresiguales);
                ErrorCrearParticionPrimaria++;
            }
            printf("Bit Inicial: %i \n",mbr2.particiones[z].part_start);
            printf("Nombre: %s \n",mbr2.particiones[z].part_name);
            printf("Tipo Estado: %c \n",mbr2.particiones[z].part_status);
            printf("Tipo Particion: %c \n",mbr2.particiones[z].part_type);
            printf("---------------------------------------------------------\n");

            if(mbr2.particiones[z].part_type=='p'||mbr2.particiones[z].part_type=='P')//si el tipo es primaria
            {
                numeroprimarias++;
            }
            if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')//si el tipo es extendida
            {
                printf("------------INICIALMENTE EXTENDIDAS---------------------\n");
                numeroextendida++;
                EBR mostrar;
                fseek(file2,mbr2.particiones[z].part_start,SEEK_SET); //escribir el bit ebr inicial
                fread(&mostrar, sizeof(EBR), 1, file2);
                printf("Inicio EBR: %i \n",mostrar.part_start);
                printf("Siguiente ebr: %i \n",mostrar.part_next);
                printf("Estado ebr: %c \n",mostrar.part_status);
            }
                printf("Tipo De Ajuste: %c \n",mbr2.particiones[z].part_fit);
                printf("Tamaño Particion %i \n", mbr2.particiones[z].part_size);
        }//fin de Recorrido de PArticiones 
        
        printf("---------------------------------------------------------\n");
        printf("****A*****Numero de Particiones primarias: %i \n",numeroprimarias);
        printf("****A*****Numero de PArticiones extendidas: %i \n",numeroextendida);
        printf("---------------------------------------------------------\n");
        
        //---------------INICIO DE CREACION DE PARTICION------------------------
        TempPrimarias=numeroprimarias;
        TempExt=numeroextendida;
        int tamanoparticion=0;

        if(funcion.unit=='b'||funcion.unit=='B') //tamaño en bytes
        {
            tamanoparticion=funcion.size;
        }
        else if(funcion.unit=='k'||funcion.unit=='K')// tamaño en kilobytes
        {
            tamanoparticion=(funcion.size*1024);
        }
        else
        {
            tamanoparticion=funcion.size*(1024*1024);
        }
        printf("Tamaño de Particion a Crear: %i \n",tamanoparticion);
        
        if(tamanoparticion<8192){//si el tamaño es menor a 2mb 2097152 arreglado a 8kb
            printf("\nInterprete (X)#: _ ERROR_6.7 El Minimo del Tamaño de la Particion es de 8KB-2M \n\n");
            ErrorCrearParticionPrimaria++;
        }else{
            
            int vacio=1;
            int i=0;
            int numeroparticion=0;
            int inicio=sizeof(MbrDisco);
            int fin=inicio+tamanoparticion;
            int ebractivo=0;
            EBR primerebr;

            if(funcion.type=='p'||funcion.type=='P'){// primaria
                numeroprimarias++;
            }
            else if(funcion.type=='e'||funcion.type=='E'){// extendida
                numeroextendida++;
                ebractivo=1;
            }
            
            if(nombresiguales>0){//si el nombre existe
                printf("\nInterprete (x)# _ ERROR_3.9 Nombre del Disco ya Existente \n\n");
                ErrorCrearParticionPrimaria++;
                ebractivo=0;
            }else// si no existe la crea
            {
                if(numeroextendida<=1 && numeroprimarias<=3 && (numeroextendida+numeroprimarias)<=4){
                    
                
                    if(tamanoparticion>mbr2.mbr_tamano){//tamaño de la particion menor q el mbr
                        ebractivo=0;
                        printf("\nInterprete (x)#: _ ERROR_4.0 El Tamaño de la Particion es Mayor q el Discos \n\n");
                        ErrorCrearParticionPrimaria++;
                    }else{//si el tamaño es correcto 
                        
                        for(i=0;i<4;i++)
                        {
                            if(mbr2.particiones[i].part_type=='e'||mbr2.particiones[i].part_type=='E'){
                                ebractivo=0;
                            }
                            if(mbr2.particiones[i].part_start!=-1 && mbr2.particiones[i].part_status!='0'){//si el estatus es 0 y inicio -1
                                vacio=0;
                            if(fin<=mbr2.particiones[i].part_start)//si el final de la part es menor q el inicio de la actual
                            {
                                break;
                            }
                            else//delocontrario crea el nuevo inicio
                            {
                                inicio=mbr2.particiones[i].part_start+mbr2.particiones[i].part_size;
                                fin=inicio+tamanoparticion;
                                numeroparticion=i+1;
                            }
                        }//fin si el estatus es 0 y inicio -1
                    }//fin de for q recorre arreglo de particiones
                        
                        if(vacio==1 && fin<=mbr2.mbr_tamano && numeroparticion<4){
                            printf("1) Disco Vacio...\n"); //era error 505 corregido
                            //ErrorT++;
                            mbr2.particiones[numeroparticion].part_start=sizeof(MbrDisco);
                            int k=0;
                            int l=0;
                            if(ebractivo==1){
                                primerebr.part_status='0';
                                primerebr.part_next=-1;
                                primerebr.part_start=-1;
                            }

                            while(funcion.name[k]!=NULL)// wile q compara el nombre de la particion
                            {
                                mbr2.particiones[numeroparticion].part_name[l++]=funcion.name[k];
                                k++;
                            }
                            
                            
                            mbr2.particiones[numeroparticion].part_size=tamanoparticion;
                            mbr2.particiones[numeroparticion].part_fit=funcion.fit[0];
                            mbr2.particiones[numeroparticion].part_allocation=funcion.allocation[0];
                            mbr2.particiones[numeroparticion].part_status='1';
                            mbr2.particiones[numeroparticion].part_type=funcion.type;
                            mbr2.particiones[numeroparticion].formateada='0';

                            printf("\n********************************************************\n");
                            printf("---'Particion Creada Con EXITO'--- ^_^ '%s'\n",funcion.name);
                            printf("\n********************************************************\n");
                            ContadorComandosExitosos++;
                            printf("Guardado...\n");
                        }// FIN si el disco esta vacio inicialmente
                        else if(vacio==0 && fin<=mbr2.mbr_tamano && numeroparticion<4)//el disco tiene porlomenos una particion
                        {
                            printf("2) Disco tiene por lo menos una particion...\n");

                            if(mbr2.particiones[numeroparticion].part_start!=1 && mbr2.particiones[numeroparticion].part_status!='0'){
                                int s=0;
                                for(s=3;s>numeroparticion;s--){
                                    printf("actual: %s \n",mbr2.particiones[s].part_name);
                                    printf("siguiente: %s \n",mbr2.particiones[s].part_name);
                                    mbr2.particiones[s]=mbr2.particiones[(s-1)];
                                }
                            }//recorre las particiones actuales

                            mbr2.particiones[numeroparticion].part_start=inicio;
                            int k=0;
                            int l=0;
                            if(ebractivo==1){
                                primerebr.part_status='0';
                                primerebr.part_next=-1;
                                primerebr.part_start=-1;
                                primerebr.part_size=0;
                            }

                            for(k=0;k<16;k++)
                            {
                                mbr2.particiones[numeroparticion].part_name[l++]=funcion.name[k];
                            }
                            
                            strcpy(mbr2.particiones[numeroparticion].part_name,funcion.name);
                            mbr2.particiones[numeroparticion].part_size=tamanoparticion;
                            mbr2.particiones[numeroparticion].part_fit=funcion.fit[0];
                            mbr2.particiones[numeroparticion].part_allocation=funcion.allocation[0];
                            mbr2.particiones[numeroparticion].part_status='1';
                            mbr2.particiones[numeroparticion].part_type=funcion.type;
                            mbr2.particiones[numeroparticion].formateada='0';

                            printf("\n********************************************************\n");
                            printf("---'Particion Creada Con EXITO'--- ^_^ '%s'\n",funcion.name);
                            printf("\n********************************************************\n");
                            ContadorComandosExitosos++;
                            printf("Guardado...\n");

                        }//fin el disco tiene porlomenos una particion
                        else
                        {
                            printf("\nInterprete (x)#: _ ERROR_4.1 No Hay espacio PAra La PArticion \n\n");
                            ErrorCrearParticionPrimaria++;
                            ebractivo=0;
                        }
                        
                    }//fin si el tamaño es correcto
             
                }//sinumeroExtendidas menor q 1 y primarias menor q 3 y primarias menor q 4
                else{
                    
                ebractivo=0;
                printf("\nInterprete (X)#: _ ERROR_4.2 No se Puede Crear debido al Numero de Particiones Extendidas y Primarias \n\n");
                ErrorCrearParticionPrimaria++;
                
                }//FIN //sinumeroExtendidas menor q 1 y primarias menor q 3 y primarias menor q 4 
                
            }// FIN verificacion de nombre
            
            if(ebractivo==1){
                fseek(file2,mbr2.particiones[numeroparticion].part_start,SEEK_SET);
                int asdf=sizeof(EBR);
                fwrite(&primerebr, sizeof(EBR), 1, file2);

                printf("\nEBR Guardado :v \n\n");
            }

            fseek(file2,0,SEEK_SET);
            fwrite(&mbr2, sizeof(MbrDisco), 1, file2);
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);

            z=0;
            for(z=0;z<4;z++){

                printf("bit inicial: %i ",mbr2.particiones[z].part_start);
                printf("nombre: %s ",mbr2.particiones[z].part_name);
                printf("tipo estado: %c ",mbr2.particiones[z].part_status);
                printf("tipo particion: %c\n",mbr2.particiones[z].part_type);
                if(mbr2.particiones[z].part_type=='e')
                {
                    EBR mostrar;
                    fseek(file2,mbr2.particiones[z].part_start,SEEK_SET);
                    fread(&mostrar, sizeof(EBR), 1, file2);
                    printf("inicio ebr: %i \n",mostrar.part_start);
                    printf("siguiente ebr: %i \n",mostrar.part_next);
                    printf("estado ebr: %c \n",mostrar.part_status);
                    printf("tamaño ebr: %i \n",mostrar.part_size);
                }
            }

            printf("\n\n|***********REPORTE ANTES DE LA OPERACION****************|\n");
            printf("Numero de particiones primarias= %i                          |\n ",TempPrimarias);
            printf("Numero de particiones extendidas= %i                         |\n",TempExt);

            printf("\n *****PArticionado Finalizado ******                       |\n");
            printf("Numero de particiones primarias= %i                          |\n",numeroprimarias);
            printf("Numero de particiones extendidas= %i                         |\n",numeroextendida);
            printf("|************************************************************|\n");
            fclose(file2);
            
        }//Fin del tamaño adecuado de Particion mayor a 2 mb
        
    }//fin if de existencia de Archivo
}

void EliminarParticion(Funcion funcion){
    ErrorEliminarParticionPrimaria=0;
    int numeroprimarias=0;
    int numeroextendida=0;
    int nombresiguales=0;

    //******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************

    int TempPrimarias=0;
    int TempExt=0;
    FILE* file2= fopen(funcion.path, "rb+");

    if (file2==NULL){  //si no existe el archivo
        printf("\nInterprete (X)#_ ERROR_4.2 Al tratar de Acceder al Archivo \n\n");
        ErrorEliminarParticionPrimaria++;

    }else{//si existe

        //Leer MBR XD
        MbrDisco mbr2;
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        
        int partcionborrar=-1;
        

        int z=0;
        int k=0;
        int l=0;
        for(z=0;z<4;z++)
        {

            if(!strcmp(mbr2.particiones[z].part_name,funcion.name)){
                partcionborrar=z;
            }

        }

        if(partcionborrar>=0)//existe
        {

            if(!strcmp(funcion.delete_,"fast")||!strcmp(funcion.delete_,"FAST"))
            {
                    int contador=0;
                    for(contador=0;contador<16;contador++)
                    {
                        mbr2.particiones[partcionborrar].part_name[contador]='\0';
                    }
                    mbr2.particiones[partcionborrar].part_status='0';
                    mbr2.particiones[partcionborrar].part_type='i'; //inactiva
                    printf("****************particion borrada en modo fast: %s\n",funcion.name);
                    
                    ContadorComandosExitosos++;

            }//fin si es fast
            else if(!strcmp(funcion.delete_,"full")||!strcmp(funcion.delete_,"FULL"))//si es en full
            {
                
                    int inicio=mbr2.particiones[partcionborrar].part_start;
                    int fin=mbr2.particiones[partcionborrar].part_start + mbr2.particiones[partcionborrar].part_size-1;
                    
/*
                    fseek(file2,inicio,SEEK_SET);
                    char buffer[fin-inicio];
                    int i=0;
                    for(i=0;i<fin-inicio;i++){
                    buffer[i]='\0';
                    }
                    fwrite(&buffer,fin , 1, file2);
*/

                    
                    
                    int contador=0;
                    for(contador=0;contador<16;contador++)
                    {
                        mbr2.particiones[partcionborrar].part_name[contador]='\0';
                    }
                    mbr2.particiones[partcionborrar].part_status='0';
                    int ebrborrar=0;
                    if(mbr2.particiones[partcionborrar].part_type=='e'||mbr2.particiones[partcionborrar].part_type=='E')
                    {
                        ebrborrar=1;
                    }
                    
                    mbr2.particiones[partcionborrar].part_type='i';
                    mbr2.particiones[partcionborrar].part_fit='\0';
                    mbr2.particiones[partcionborrar].part_size=0;
                    mbr2.particiones[partcionborrar].part_size=0;
                    mbr2.particiones[partcionborrar].part_start=-1;
                    
                    
                    
                    
                    printf("*******************particion borrada con exito Modo FUll: %s\n",funcion.name);
                    ContadorComandosExitosos++;

            }//fin del modo fulls

        }//fin de particion existe
        else{

            printf("\n ::::::::::::::::::La PArticion: '%s'  No existe en Las Primarias y Extendidas \n",funcion.name);
            
            int comparador=ExisteLogica(funcion.name,funcion);           
            if(comparador==0){
                
            printf("\n\n*************Particion No Existe TAmpoco en las Logicas (Finaliza cn Error)\n ");
            printf("\nInterprete (X)#: _ ERROR555 Al tratar de Acceder al Archivo (no existe en las particiones Primarias , Extendidas y Logicas) \n Nombre:: %s \n",funcion.name);
            ErrorT++;
            
            }else{
            printf("*************Particion Existe y esta en las Logicas (llama al metodo Eliminar Logicas)");
            //------------------------------------------------------------------Eliminar Logica
            EliminarLogica(funcion);
            }



        }//fin si no existe la primaria se va a logica

        fseek(file2,0,SEEK_SET);
        fwrite(&mbr2, sizeof(MbrDisco), 1, file2);
        fclose(file2);

    }//fin si existe el archivo

    file2= fopen(funcion.path, "rb+");
    MbrDisco mbr2;
    fseek(file2,0,SEEK_SET);
    fread(&mbr2, sizeof(MbrDisco), 1, file2);
    fclose(file2);

    int z=0;
    for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
        int k=0;
        int l=0;
        while(funcion.name[k]!=NULL){
            if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                l++;
            }
            k++;
        }
        if(l==k && mbr2.particiones[z].part_status!='0'){// si las coincidencias son iguales y el status 0
            printf("-----EL ESTATUS ES 0");
        }

        if(mbr2.particiones[z].part_type=='p'||mbr2.particiones[z].part_type=='P')//si el tipo es primaria
        {
        numeroprimarias++;
        }
        if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')//si el tipo es extendida
        {
        numeroextendida++;
        }

    }//fin for de recorrer particiones


    printf("\n\n *****Eliminado Finalizado ******\n\n");
    printf("Numero de particiones primarias= %i\n",numeroprimarias);
    printf("Numero de particiones extendidas= %i\n\n",numeroextendida);
    printf("**ERRORES ENCONTRADOS::::::: %i\n",ErrorEliminarParticionPrimaria);


}

void CrearParticionLogica(Funcion funcion){

    Funcion funcionaux=funcion;

    int nombresiguales=0;
    int numeroextendida=0;
    int idextendida=-1;
    int tamanooextendida=0;
    int inicio=-1; int fin=-1;
    char*nombreextendida;
    int contador=0;


    //arregla el path del archivo para encontrarlo
    //******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************

    int existe=ExisteLogica(funcionaux.name,funcion);
    printf("EXISTENCIA**************************************************************  %i \n",existe);

    if(existe==0){

        FILE* file2= fopen(funcion.path, "rb+");
        if (file2==NULL)
        {
            printf("\nInterprete (X)#: _ ERROR_4.5: Al tratar de Acceder al Archivo \n\n\n");
            ErrorCrearParticionLogica++;

        }
        else
        {
            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
            int z;
            for(z=0;z<4;z++)
            {
                if(!strcmp(mbr2.particiones[z].part_name,funcion.name)&& mbr2.particiones[z].part_status!='0'){
                    nombresiguales=1;
                    printf("\nInterprete (X)#: _ ERROR_4.6 Particiones Iguales \n\n %i \n",nombresiguales);
                    ErrorCrearParticionLogica++;
                }
                if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')
                {
                    numeroextendida++;
                    idextendida=z;
                    tamanooextendida=mbr2.particiones[z].part_size;
                    nombreextendida=mbr2.particiones[z].part_name;
                }

            }//fin del for de recorrido de particiones
            
             if(nombresiguales>0){
                printf("\nInterprete ()#: _ ERROR_4.7 Nombre de la PArticion ya Existente \n\n %s \n",funcion.name);
                ErrorCrearParticionLogica++;
            }
            else{

                printf("particion logiaca a crear= %s \n",funcion.name);
                printf("****particion Extendida donde se Crea= %s \n",nombreextendida);
                printf("tamaño de particion extendida= %i \n",tamanooextendida);
                printf("id particion = %i \n",idextendida);
                printf("tamaño ebr: %i \n",sizeof(EBR));
                int tamanoparticion=0;
                if(funcion.unit=='b'||funcion.unit=='B')
                {
                    tamanoparticion=funcion.size;
                }
                else if(funcion.unit=='k'||funcion.unit=='K')
                {
                    tamanoparticion=(funcion.size*1024);
                }
                else
                {
                    tamanoparticion=funcion.size*(1024*1024);
                }
                
                printf("tamaño particion: %i \n",tamanoparticion);
                int vacio=1;
                EBR ebr;
                int actual=mbr2.particiones[idextendida].part_start;
                printf("posicion actual %i\n",actual);
                fseek(file2,actual,SEEK_SET);
                fread(&ebr, sizeof(EBR), 1, file2);
                int next=ebr.part_next;
                inicio=sizeof(EBR);
                int fin=inicio+tamanoparticion;
                int numeroebr=0;
                int espaciolibre=mbr2.particiones[idextendida].part_size;
                espaciolibre-=32;

                do{
                if(ebr.part_next!=-1){
                    actual+=sizeof(EBR);
                    actual+=ebr.part_size;
                    printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    next=ebr.part_next;
                    contador++;
                }
                contador++;
                }while(next!=-1);

                //la posicion es el numero de ebr mas 1
                EBR indices[contador+1];
                contador=0;//reinica contador
                actual=mbr2.particiones[idextendida].part_start;//coloca como el actual el inicio del ebr denuevo
                fseek(file2,actual,SEEK_SET);//lee la primera ebr
                fread(&indices[contador], sizeof(EBR), 1, file2);//lee las particiones de espacio no las ebr

                do{
                printf("viejo------------------------------------------------------------\n");
                printf("fit %c\n",indices[contador].part_fit);
                printf("name %s\n",indices[contador].part_name);
                printf("next %i\n",indices[contador].part_next);
                printf("size %i\n",indices[contador].part_size);
                printf("inicio %i\n",indices[contador].part_start);
                printf("estado %c\n",indices[contador].part_status);
                printf("------------------------------------------------------------\n");
                if(indices[contador].part_next!=-1){
                    printf("contador %i\n",contador);
                    actual+=sizeof(EBR);
                    actual+=indices[contador].part_size;
                    printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador+1], sizeof(EBR), 1, file2);
                    next=indices[contador].part_next;
                    printf("siguiente %i\n",next);
                }else{
                    printf("contador %i\n",contador);
                    next=-1;
                }
                    contador++;
                }while(next!=-1);


                //el contador aun tiene el numero anterior de particiones

                int i=0;
                for(i=0;i<contador;i++){
                    if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0' .-------------------Arreglo#1
                        vacio=0;
                        printf("mostrar part_name: %s\n",indices[i].part_name);
                        if(fin<=(indices[i].part_start-sizeof(EBR))){
                            break;//nunk entra
                        }
                        else
                        {
                            inicio=indices[i].part_start+indices[i].part_size+sizeof(EBR);
                            fin=inicio+tamanoparticion;
                            numeroebr=i+1;
                        }
                        if(i==0){
                            espaciolibre=espaciolibre-indices[i].part_size;
                        }else{
                            espaciolibre=espaciolibre-indices[i].part_size-sizeof(EBR);
                        }

                    }
                }//fin del for q recorre el inicio y fin

                printf("**Total:::::: %i\n",contador);
                printf("posicion %i\n",numeroebr);
                printf("espacio libre %i\n",espaciolibre);
                printf("inicio %i\n",inicio);
                printf("final %i\n",fin);

                if(fin<tamanooextendida){
                    if(indices[numeroebr].part_start==-1){
                        indices[numeroebr].part_start=inicio;
                        int k=0;
                        int l=0;
                        for(k=0;k<16;k++)
                        {
                            indices[numeroebr].part_name[l++]=funcion.name[k];
                        }
                        //mbr2.particiones[numeroparticion].part_name=funcion.name;
                        indices[numeroebr].part_size=tamanoparticion;
                        indices[numeroebr].part_fit=funcion.fit[0];
                        indices[numeroebr].part_status='1';
                        indices[numeroebr].part_next=-1;
                        printf("escribiendo....................\n");
                        actual=mbr2.particiones[idextendida].part_start;
                        fseek(file2,actual,SEEK_SET);
                        fwrite(&indices[numeroebr], sizeof(EBR), 1, file2);
                        printf("******Guardado...\n");
                        ContadorComandosExitosos++;
                        contador++;
                    }else{
                    int j=0;
                    for(j=numeroebr;j<(contador+1);j++){//no entra
                        if((j+1)<(contador+1)){
                            indices[j+1]=indices[j];
                        }
                    }
                    indices[numeroebr].part_start=inicio;
                    int k=0;
                    int l=0;
                    for(k=0;k<16;k++)
                    {
                        indices[numeroebr].part_name[l++]=funcion.name[k];
                    }
                    //mbr2.particiones[numeroparticion].part_name=funcion.name;
                    indices[numeroebr].part_size=tamanoparticion;
                    indices[numeroebr].part_fit=funcion.fit[0];
                    indices[numeroebr].part_status='1';
                    indices[numeroebr].part_next=-1;
                    if((numeroebr-1)>=0){
                        indices[numeroebr-1].part_next=indices[numeroebr].part_start-sizeof(EBR); //claveee aqui manejan los registros


                    }
                    if((numeroebr+1)<(contador+1)){//no entra
                        indices[numeroebr].part_next=indices[numeroebr+1].part_start-sizeof(EBR);
                    }
                    //printf("escribiendo....................\n");
                    actual=mbr2.particiones[idextendida].part_start;
                    int escribir=0;
                    for(escribir=0;escribir<(contador+1);escribir++){
                        printf("-----------------------nueva-------------------------------------\n");
                        printf("fit %c\n",indices[escribir].part_fit);
                        printf("name %s\n",indices[escribir].part_name);
                        printf("next %i\n",indices[escribir].part_next);
                        printf("size %i\n",indices[escribir].part_size);
                        printf("inicio %i\n",indices[escribir].part_start);
                        printf("estado %c\n",indices[escribir].part_status);
                        printf("------------------------------------------------------------\n");
                    printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fwrite(&indices[escribir], sizeof(EBR), 1, file2);
                    actual+=sizeof(EBR);
                    actual+=indices[escribir].part_size;
                    }

                    printf("******Guardado...\n");
                    ContadorComandosExitosos++;
                    contador++;
                }
            }else{
                printf("\n Interprete #_ ERROR_4.8 No hay Espcio suficiente para el Particionado Logico \n\n");
                ErrorCrearParticionLogica++;
            }

            }//fin del if q verifica nombres

            fclose(file2);
        }//fin del if del file


        printf("\n\n *****PArticionado Logico Finalizado ******\n\n");
        printf("Numero de particiones extendidas= %i\n\n",numeroextendida);
        printf("Nombre de la Particion Extendida= %s\n\n",nombreextendida);
        printf("Numero de particiones Logicas en La Extendida= %i\n\n",contador);
        printf("**ERRORES ENCONTRADOS::::::: %i\n",ErrorCrearParticionLogica);

    }else{//si la particion tiene el mismo nombre

       printf("\n Interprete #_ ERROR_5.6 Este Nombre de PArticion YA Existe \n\n\n");
       ErrorCrearParticionLogica++;

    }

}

void EliminarLogica(Funcion funcion){

    int aux=0;
    int ErrorT=0;
    int nombresiguales=0;
    int numeroextendida=0;
    int idextendida=-1;
    int tamanooextendida=0;
    int inicio=-1; 
    int fin=-1;
    char*nombreextendida;
    int contador=0;
    
     //arregla el path del archivo para encontrarlo
    //******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    
    
    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL)
    {
        printf("\nInterprete (X)#: _ ERROR_5.0Logicas Al tratar de Acceder al Archivo \n\n\n");
        ErrorEliminarLogica++;
    }
    else//si existe a borrar
    {
        MbrDisco mbr2;
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        int z;
        
        
        for(z=0;z<4;z++)
        {
            if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')
            {
                numeroextendida++;
                idextendida=z;
                tamanooextendida=mbr2.particiones[z].part_size;
                nombreextendida=mbr2.particiones[z].part_name;
            }
        }
        
        //tramo2----------------------
        int tamanoparticionBorrada=0;
        
        EBR ebr;
        int actual=mbr2.particiones[idextendida].part_start;
        printf("0_posicion actual %i\n",actual);
        fseek(file2,actual,SEEK_SET);
        fread(&ebr, sizeof(EBR), 1, file2);
        int next=ebr.part_next;
            
        do{
            if(ebr.part_next!=-1){
                actual+=sizeof(EBR);
                actual+=ebr.part_size;
                printf("1_posicion actual %i\n",actual);
                fseek(file2,actual,SEEK_SET);
                fread(&ebr, sizeof(EBR), 1, file2);
                next=ebr.part_next;
                contador++;
            }
            contador++;
        }while(next!=-1);
            
            
        //printf("-----------------Lista de Particiones------------------------\n");
        int contador2=contador;
        EBR indices[contador];//modifico tamaño del arreglo
        contador=0;
        actual=mbr2.particiones[idextendida].part_start;
        fseek(file2,actual,SEEK_SET);
        fread(&indices[contador], sizeof(EBR), 1, file2);
            
        do{
            printf("------------------------------------------------------------\n");
            printf("fit %c\n",indices[contador].part_fit);
            printf("name %s\n",indices[contador].part_name);
            printf("next %i\n",indices[contador].part_next);
            printf("size %i\n",indices[contador].part_size);
            printf("inicio %i\n",indices[contador].part_start);
            printf("estado %c\n",indices[contador].part_status);
            printf("------------------------------------------------------------\n");
            if(indices[contador].part_next!=-1){
                printf("contador %i\n",contador);
                actual+=sizeof(EBR);
                actual+=indices[contador].part_size;
                printf("posicion actual %i\n",actual);
                fseek(file2,actual,SEEK_SET);
                fread(&indices[contador+1], sizeof(EBR), 1, file2);
                next=indices[contador].part_next;
                printf("siguiente %i\n",next);
            }else{
                printf("contador %i\n",contador);
                next=-1;
            }
            contador++;
        }while(next!=-1);
            
            
            
        char*a;
        int i=0;
        for(i=0;i<contador;i++){
            if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0'
                //vacio=0;
                printf("mostrar part_name: %s\n",indices[i].part_name);
                a=indices[i].part_name;
                
                printf("mostrar a borrar: %s\n",funcion.name);
                
                if(strcasecmp(funcion.name,a)==0 && indices[i].part_status!='0'){//encontro la particion a borrar  y su estatudus es diferente de 0
                    if(!strcmp(funcion.delete_,"fast"))//si el modo es fast :V
                    {

                        indices[i].part_status='0';
                        indices[i].part_fit='\0';
  
                        strcpy(indices[i].part_name,"Espacio Libre");
                        
                        
                        

                    }else if(!strcmp(funcion.delete_,"full"))//si es modo full
                    {


/*
                        int inicio2=indices[i].part_start;
                        int tam=indices[i].part_size;
                        int fin2=inicio2+tam;

                        indices[i].part_status='0';
                        indices[i].part_size='0';
                        indices[i].part_start=-1;
                        //indices[i].part_next=-1;
                        int contador=0;
                        for(contador=0;contador<16;contador++)
                        {
                            indices[i].part_name[contador]='\0';
                        }
                        indices[i].part_fit='\0';

                        fseek(file2,inicio2,SEEK_SET);
                        char relleno='\0';
                        int cont=0;
                        for (cont = inicio2; cont < fin2; cont++) {
                            fwrite(&relleno, 1, 1, file2);
                        }
                        //rewind(file2);
                        fclose(file2);
*/

                        indices[i].part_status='0';
                        indices[i].part_fit='\0';
                        indices[i].part_size='0';
                        
                        for(contador=0;contador<16;contador++)
                        {
                            indices[i].part_name[contador]='\0';
                        }
                        
/*
                        
                        int inicio=indices[i].part_start;
                        int fin=indices[i].part_size + inicio;
                        char buffer[1024];
                        int i=0;
                        for(i=0;i<1024;i++){
                        buffer[i]='\0';
                        }

                        for(int j=inicio; j<=fin; j++){
                        fwrite(&buffer,1024 , 1, file2);
                        j++;
                        }
*/
                        

                    }
                
                
                }//fin del if donde encuentra
                
            }//fin del if q recorre

                   
        }//fin del for 
            
            //inicio de la EscrituraSSS      
            actual=mbr2.particiones[idextendida].part_start;
            int escribir=0;
            for(escribir=0;escribir<(contador2);escribir++){
                        
                        printf("-----------------------ESCRIBE-------------------------------------\n");
                        printf("fit %c\n",indices[escribir].part_fit);
                        printf("name %s\n",indices[escribir].part_name);
                        printf("next %i\n",indices[escribir].part_next);
                        printf("size %i\n",indices[escribir].part_size);
                        printf("inicio %i\n",indices[escribir].part_start);
                        printf("estado %c\n",indices[escribir].part_status);
                        printf("------------------------------------------------------------\n");
                        printf("posicion actual %i\n",actual);
                        
                    fseek(file2,actual,SEEK_SET);
                    fwrite(&indices[escribir], sizeof(EBR), 1, file2);
                    actual+=sizeof(EBR);
                    actual+=indices[escribir].part_size;
                    
            }  
        
    }//fin file2
    
    
    fclose(file2);
    
}

void AgregarEspacio(Funcion funcion){

//******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    //**************************************************************************

    int nombresiguales=0;
    int numeroprimarias=0;
    int numeroextendida=0;

    int TempPrimarias=0;
    int TempExt=0;

    // *************************INICIO DE CREACION******************************
    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL){ //si no existe el archivo
            printf("\n Interprete #_ ERROR_3.7 Al tratar de Acceder al Archivo \n\n");
            ErrorCrearParticionPrimaria++;
            //Aqui Va el Error Crear PArticion Logica
    }else{//si existe
        //-------------------------LECTURA DEL ARCHIVO--------------------------
        MbrDisco mbr2;
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        //------------------------IMPRIMIR DATOS DEL DISCO----------------------
        printf("-----------CrearParticion Datos Del Disco--------------------\n");
        printf("%i",mbr2.mbr_disk_signature);
        printf("\n");
        printf(mbr2.mbr_fecha_creacion);
        printf("\n");
        printf("Tamaño %i",mbr2.mbr_tamano);
        printf("-----------INICIALMENTE Primarias----------------------------\n");
        int z=0;
        int particionModificar=-1;
        for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias

            if(!strcmp(mbr2.particiones[z].part_name,funcion.name)){
                particionModificar=z;
            }   
        }//fin de Recorrido de PArticiones
        
        if(particionModificar==-1){
        //NO EXISTE LA PARTICION
        }else{
            
            
        int tamanoparticion=0;

         if(funcion.unit=='b'||funcion.unit=='B') //tamaño en bytes
        {
            tamanoparticion=funcion.add;
        }
        else if(funcion.unit=='k'||funcion.unit=='K')// tamaño en kilobytes
        {
            tamanoparticion=(funcion.add*1024);
        }
        else
        {
            tamanoparticion=funcion.add*(1024*1024);
        }
        
        tamanoparticion=tamanoparticion+mbr2.particiones[particionModificar].part_size;
        printf("Tamaño de Particion a Crear: %i \n",tamanoparticion);
        char backupType=mbr2.particiones[particionModificar].part_type;
        
        if(tamanoparticion<2097152){
            printf("\n Interprete #_ ERROR_6.7 El Minimo del Tamaño de la Particion es de 2M \n\n");
            ErrorCrearParticionPrimaria++;
        }else{
            
            
            //ELIMINA LA VIEJAA
            Funcion fEliminar;            
            strcpy(fEliminar.delete_,"full");
            strcpy(fEliminar.path,funcion.path);
            strcpy(fEliminar.name,funcion.name);
            EliminarParticion(fEliminar);
            
            Funcion fAgregar;
            strcpy(fAgregar.name,funcion.name);
            strcpy(fAgregar.path,funcion.path);
            fAgregar.type=backupType;
            fAgregar.unit='b';       
            fAgregar.size=tamanoparticion;
            strcpy(fAgregar.fit,"wf");
            CrearParticion(fAgregar);   
            
        }//si el tamaño es el correcto
        
        }//si existe la particion

    }//fin de lo del FILE  
    

}

void QuitarEspacio(Funcion funcion){

//******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    //**************************************************************************

    int nombresiguales=0;
    int numeroprimarias=0;
    int numeroextendida=0;

    int TempPrimarias=0;
    int TempExt=0;

    // *************************INICIO DE CREACION******************************
    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL){ //si no existe el archivo
            printf("\n Interprete #_ ERROR_3.7 Al tratar de Acceder al Archivo \n\n");
            ErrorCrearParticionPrimaria++;
            //Aqui Va el Error Crear PArticion Logica
    }else{//si existe
        //-------------------------LECTURA DEL ARCHIVO--------------------------
        MbrDisco mbr2;
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        //------------------------IMPRIMIR DATOS DEL DISCO----------------------
        printf("-----------CrearParticion Datos Del Disco--------------------\n");
        printf("%i",mbr2.mbr_disk_signature);
        printf("\n");
        printf(mbr2.mbr_fecha_creacion);
        printf("\n");
        printf("Tamaño %i",mbr2.mbr_tamano);
        printf("-----------INICIALMENTE Primarias----------------------------\n");
        int z=0;
        int particionModificar=-1;
        for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias

            if(!strcmp(mbr2.particiones[z].part_name,funcion.name)){
                particionModificar=z;
            }   
        }//fin de Recorrido de PArticiones
        
        if(particionModificar==-1){
        //NO EXISTE LA PARTICION
        }else{
            
            
        int tamanoparticion=0;

         if(funcion.unit=='b'||funcion.unit=='B') //tamaño en bytes
        {
            tamanoparticion=funcion.add;
        }
        else if(funcion.unit=='k'||funcion.unit=='K')// tamaño en kilobytes
        {
            tamanoparticion=(funcion.add*1024);
        }
        else
        {
            tamanoparticion=funcion.add*(1024*1024);
        }
        
        tamanoparticion=mbr2.particiones[particionModificar].part_size-tamanoparticion;
        printf("Tamaño de Particion a Crear: %i \n",tamanoparticion);
        char backupType=mbr2.particiones[particionModificar].part_type;
        
        if(tamanoparticion<2097152&&tamanoparticion>0){
            printf("\n Interprete #_ ERROR_6.7 El Minimo del Tamaño de la Particion es de 2M \n\n");
            ErrorCrearParticionPrimaria++;
        }else{
            
            
            //ELIMINA LA VIEJAA
            Funcion fEliminar;            
            strcpy(fEliminar.delete_,"full");
            strcpy(fEliminar.path,funcion.path);
            strcpy(fEliminar.name,funcion.name);
            EliminarParticion(fEliminar);
            
            Funcion fAgregar;
            strcpy(fAgregar.name,funcion.name);
            strcpy(fAgregar.path,funcion.path);
            fAgregar.type=backupType;
            fAgregar.unit='b';       
            fAgregar.size=tamanoparticion;
            strcpy(fAgregar.fit,"wf");
            CrearParticion(fAgregar);   
            
        }//si el tamaño es el correcto
        
        }//si existe la particion

    }//fin de lo del FILE  
    

}

int NumeroDeLogicas(Funcion funcion){//retorna 1 si ya esta la particion, y 0 si no existe 
    
   int aux=0;
    
    int ErrorT=0;
    int nombresiguales=0;
    //int numeroprimarias=0;
    int numeroextendida=0;
    int idextendida=-1;
    int tamanooextendida=0;
    int inicio=-1; int fin=-1;
    char*nombreextendida;
    int contador=0;
    
    //arregla el path del archivo para encontrarlo
    //******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    
    
    
    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL)
    {
        printf("\n Interprete #_ ERROR5 Al tratar de Acceder al Archivo \n\n\n");
        ErrorT++;
    }
    else
    {
        MbrDisco mbr2;
        //printf("%d",ftell(file2));
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        int z;
        int tamanoparticion=0;
        
        for(z=0;z<4;z++)
        {
            int k=0,l=0;
            while(funcion.name[k]!=NULL){
                if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                l++;
                }
                k++;
            }

            if(mbr2.particiones[z].part_type=='e'|| mbr2.particiones[z].part_type=='E')
            {
                numeroextendida++;
                idextendida=z;
                tamanooextendida=mbr2.particiones[z].part_size;
                nombreextendida=mbr2.particiones[z].part_name;
            }
        }

        if(nombresiguales>0){
        printf("\n Interprete #_ ERROR21 Nombre de la PArticion ya Existente \n\n %s \n",funcion.name);
        ErrorT++;
        }
        else{

            int vacio=1;
            EBR ebr;
            int actual=mbr2.particiones[idextendida].part_start;
            //printf("posicion actual %i\n",actual);
            fseek(file2,actual,SEEK_SET);
            fread(&ebr, sizeof(EBR), 1, file2);
            int next=ebr.part_next;
            inicio=sizeof(EBR);

            int fin=inicio+tamanoparticion;
            //int contador=0;
            int numeroebr=0;
            int espaciolibre=mbr2.particiones[idextendida].part_size;
            espaciolibre-=32;
            do{
                if(ebr.part_next!=-1){
                    actual+=sizeof(EBR);
                    actual+=ebr.part_size;
                    //printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    next=ebr.part_next;
                    contador++;
                }
                contador++;
            }while(next!=-1);

            printf("-----------------Lista de Particiones------------------------\n");

            EBR indices[contador+1];
            contador=0;
            actual=mbr2.particiones[idextendida].part_start;
            fseek(file2,actual,SEEK_SET);
            fread(&indices[contador], sizeof(EBR), 1, file2);
            do{

                if(indices[contador].part_next!=-1){
                    
                    actual+=sizeof(EBR);
                    actual+=indices[contador].part_size;
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador+1], sizeof(EBR), 1, file2);
                    next=indices[contador].part_next;
                    
                }else{
                    
                    next=-1;
                }
                contador++;
            }while(next!=-1);

            char a[100];
            int i=0;
            for(i=0;i<contador;i++){
                if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0'
                vacio=0;

                //a=indices[i].part_name;

                aux++;
              

                
                if(fin<=(indices[i].part_start-sizeof(EBR))){
                    break;
                }
                else
                {
                    inicio=indices[i].part_start+indices[i].part_size+sizeof(EBR);
                    fin=inicio+tamanoparticion;
                    numeroebr=i+1;
                }
                if(i==0){
                espaciolibre=espaciolibre-indices[i].part_size;
                }else{
                espaciolibre=espaciolibre-indices[i].part_size-sizeof(EBR);
                }

                }
                }
//---------

        }

        fclose(file2);
    }
    
    return aux;
}

int ExisteLogica(char nombre[], Funcion funcion){//retorna 1 si ya esta la particion, y 0 si no existe

    int aux=0;

    int ErrorT=0;
    int nombresiguales=0;
    //int numeroprimarias=0;
    int numeroextendida=0;
    int idextendida=-1;
    int tamanooextendida=0;
    int inicio=-1; int fin=-1;
    char*nombreextendida;
    int contador=0;

    //arregla el path del archivo para encontrarlo
    //******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************



    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL)
    {
        printf("\nInterprete (X)#: _ ERROR5 Al tratar de Acceder al Archivo \n\n\n");
        ErrorT++;
    }
    else
    {
        MbrDisco mbr2;
        //printf("%d",ftell(file2));
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        int z;
        int tamanoparticion=0;

        for(z=0;z<4;z++)
        {
            int k=0,l=0;
            while(funcion.name[k]!=NULL){
                if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                l++;
                }
                k++;
            }

            if(mbr2.particiones[z].part_type=='e'|| mbr2.particiones[z].part_type=='E')
            {
                numeroextendida++;
                idextendida=z;
                tamanooextendida=mbr2.particiones[z].part_size;
                nombreextendida=mbr2.particiones[z].part_name;
            }
        }

        if(idextendida==-1){ //si no encuentra la 
        printf("\nInterprete (X)#: _ ERROR21(ExisteLOgica(metodo)) O no hay extendida Nombre de la PArticion ya Existente \n\n %s \n",funcion.name);
        ErrorT++;
        }
        else{

            int vacio=1;
            EBR ebr;
            int actual=mbr2.particiones[idextendida].part_start;
            //printf("posicion actual %i\n",actual);
            fseek(file2,actual,SEEK_SET);
            fread(&ebr, sizeof(EBR), 1, file2);
            int next=ebr.part_next;
            inicio=sizeof(EBR);

            int fin=inicio+tamanoparticion;
            int contador=0;
            int numeroebr=0;
            int espaciolibre=mbr2.particiones[idextendida].part_size;
            espaciolibre-=32;
            do{
                if(ebr.part_next!=-1){
                    actual+=sizeof(EBR);
                    actual+=ebr.part_size;
                    printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    next=ebr.part_next;
                    contador++;
                }
                contador++;
                if(contador==500){
                    break;
                }
            }while(next!=-1);

            printf("-----------------Lista de Particiones------------------------\n");

            EBR indices[contador+1];
            contador=0;
            actual=mbr2.particiones[idextendida].part_start;
            fseek(file2,actual,SEEK_SET);
            fread(&indices[contador], sizeof(EBR), 1, file2);
            do{

                if(indices[contador].part_next!=-1){

                    actual+=sizeof(EBR);
                    actual+=indices[contador].part_size;
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador+1], sizeof(EBR), 1, file2);
                    next=indices[contador].part_next;

                }else{

                    next=-1;
                }
                contador++;
            }while(next!=-1);

            char a[100];
            int i=0;
            for(i=0;i<contador;i++){
                if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0'
                vacio=0;

                //a=indices[i].part_name;

                if(strcasecmp(nombre,indices[i].part_name)==0 && indices[i].part_status!='0'){

                    aux=1;
                }


/*             COMENTE ESTO LA NOCHE DEL LUNES
                if(fin<=(indices[i].part_start-sizeof(EBR))){
                    break;
                }
                else
                {
                    inicio=indices[i].part_start+indices[i].part_size+sizeof(EBR);
                    fin=inicio+tamanoparticion;
                    numeroebr=i+1;
                }
                if(i==0){
                espaciolibre=espaciolibre-indices[i].part_size;
                }else{
                espaciolibre=espaciolibre-indices[i].part_size-sizeof(EBR);
                }
*/

                }
                }
//---------

        }

        fclose(file2);
    }

    return aux;
}



//---------------------------Reportes en Consola--------------------------------
void ls(Funcion funcion){
    
    char* nombreextendida;
    
    printf("\n\n**************** InforMacion de Disco ***********************\n\n");
    int ErrorT=0;
//******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    
    int nombresiguales=0;
    int numeroprimarias=0;
    int numeroextendida=0;
    
    int TempPrimarias=0;
    int TempExt=0;
    
    printf("Disco:: %s",pathauxiliar);
    printf("\n");
    
        FILE* file2= fopen(funcion.path, "rb+");
        if (file2==NULL){  //si no existe el archivo
            printf("\nInterprete (X)#: _ ERROR5 Al tratar de Acceder al Archivo \n\n");
            ErrorT++;
            
        }else{//si existe
            
            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
            printf("Asignacion:: %i",mbr2.mbr_disk_signature);
            printf("\n");
            printf("Fecha de Consulta:: %s",mbr2.mbr_fecha_creacion);
            printf("\n");
            printf("Tamaño de Unidad:: %i",mbr2.mbr_tamano);
            printf("\n\n");
            printf("----------------Particiones En Disco------------------------\n");
            int z=0;
            for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                int k=0;
                int l=0;
                while(funcion.name[k]!=NULL){
                if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                    l++;
                }
                    k++;
                }
                
                if(mbr2.particiones[z].part_type=='p'||mbr2.particiones[z].part_type=='P')//si el tipo es primaria
                {
                    
                printf("*Primaria, Nombre:: %s",mbr2.particiones[z].part_name);
                printf(",Tamaño:: %i",mbr2.particiones[z].part_size);
                printf("\n");
                numeroprimarias++;
                
                }
                if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')//si el tipo es extendida
                {
                printf("*Extendida, Nombre:: %s",mbr2.particiones[z].part_name);
                printf(",Tamaño:: %i",mbr2.particiones[z].part_size);
                printf("\n");
                
                nombreextendida=mbr2.particiones[z].part_name;
                numeroextendida++;
/*
                EBR mostrar;
                fseek(file2,mbr2.particiones[z].part_start,SEEK_SET); //escribir el bit ebr inicial
                fread(&mostrar, sizeof(EBR), 1, file2);
                printf("Inicio EBR: %i \n",mostrar.part_start);
                printf("Siguiente ebr: %i \n",mostrar.part_next);
                printf("Estado ebr: %c \n",mostrar.part_status);
*/
                }
/*
                printf("Tipo De Ajuste: %c \n",mbr2.particiones[z].part_fit);
                printf("Tamaño Particion %i \n", mbr2.particiones[z].part_size);
*/
            }
            
            printf("************************************************************ \n");
            printf("*********Numero de Particiones primarias:   %i \n",numeroprimarias);
            printf("*********Numero de PArticiones extendidas:  %i \n",numeroextendida);
            printf("************************************************************ \n");
            
            if(numeroextendida!=0){
                
                printf(":::::::::Reporte De Particion Extendida: '%s'  \n",nombreextendida);
                lsl(funcion);
                
            }else{
            
                printf("--No Existe Particiones Extendidas en la Unidad \n");
                
            }

        }
}

void lsl(Funcion funcion){
        
    int ErrorT=0;
    int nombresiguales=0;
    //int numeroprimarias=0;
    int numeroextendida=0;
    int idextendida=-1;
    int tamanooextendida=0;
    int inicio=-1; int fin=-1;
    char*nombreextendida;
    int contador=0;
    
//******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    
    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL)
    {
        printf("\nInterprete (X)#_ ERROR5 Al tratar de Acceder al Archivo \n\n\n");
        ErrorT++;
    }
    else
    {
        MbrDisco mbr2;
        //printf("%d",ftell(file2));
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        int z;
        
        
        for(z=0;z<4;z++)
        {
            int k=0,l=0;
            while(funcion.name[k]!=NULL){
                if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                    l++;
                }k++;
            }

            if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')
            {
                numeroextendida++;
                idextendida=z;
                tamanooextendida=mbr2.particiones[z].part_size;
                nombreextendida=mbr2.particiones[z].part_name;
            }
        }

        if(nombresiguales>0){
        printf("\nInterprete (X)#: _ ERROR21 Nombre de la PArticion ya Existente \n\n %s \n",funcion.name);
        ErrorT++;
        }
        else{

            int tamanoparticion=0;
            if(funcion.unit=='b')
            {
                tamanoparticion=funcion.size;
            }
            else if(funcion.unit=='k')
            {
                tamanoparticion=(funcion.size*1024);
            }
            else
            {
                tamanoparticion=funcion.size*(1024*1024);
            }

            int vacio=1;
            EBR ebr;
            int actual=mbr2.particiones[idextendida].part_start;
            //printf("posicion actual %i\n",actual);
            fseek(file2,actual,SEEK_SET);
            fread(&ebr, sizeof(EBR), 1, file2);
            int next=ebr.part_next;
            inicio=sizeof(EBR);

            int fin=inicio+tamanoparticion;
            //int contador=0;
            int numeroebr=0;
            int espaciolibre=mbr2.particiones[idextendida].part_size;
            espaciolibre-=32;
            do{
                if(ebr.part_next!=-1){
                    actual+=sizeof(EBR);
                    actual+=ebr.part_size;
                    printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    next=ebr.part_next;
                    contador++;
                }
                contador++;
            }while(next!=-1);

            printf("-----------------Lista de Particiones------------------------\n");

            EBR indices[contador+1];
            contador=0;
            actual=mbr2.particiones[idextendida].part_start;
            fseek(file2,actual,SEEK_SET);
            fread(&indices[contador], sizeof(EBR), 1, file2);
            do{

                if(indices[contador].part_next!=-1){
                    //printf("contador %i\n",contador);
                    actual+=sizeof(EBR);
                    actual+=indices[contador].part_size;
                    //printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador+1], sizeof(EBR), 1, file2);
                    next=indices[contador].part_next;
                    //printf("siguiente %i\n",next);
                }else{
                    //printf("contador %i\n",contador);
                    next=-1;
                }
                contador++;
            }while(next!=-1);

            int i=0;
            for(i=0;i<contador;i++){
                if(indices[i].part_start!=-1 && indices[i].part_status!='0'){//&& indices[i].part_status!='0'
                vacio=0;
                
                //printf("*Nomb%s\n",indices[i].part_name);
                printf("**Logica, Nombre:: %s",indices[i].part_name);
                printf(",Tamaño:: %i",indices[i].part_size);
                printf("\n");
                printf(",Status:: %c",indices[i].part_status);
                printf("\n");
                printf(",Start:: %i",indices[i].part_start);
                printf("\n");
                printf(",Next:: %i",indices[i].part_next);
                printf("\n");
                
/*     ESTO LO COMENTE EL DIA Lunes 20 de febrero :V 2017
                if(fin<=(indices[i].part_start-sizeof(EBR))){
                    break;
                }
                else
                {
                    inicio=indices[i].part_start+indices[i].part_size+sizeof(EBR);
                    fin=inicio+tamanoparticion;
                    numeroebr=i+1;
                }
                if(i==0){
                espaciolibre=espaciolibre-indices[i].part_size;
                }else{
                espaciolibre=espaciolibre-indices[i].part_size-sizeof(EBR);
                }
*/

                }
                }
            
            //aqui envez de la funcion iba el contador :v
            printf("**************** Info ************************************** \n");
            printf("Total:::::: %i\n",NumeroDeLogicas(funcion));  
            printf("-Posicion: %i\n",numeroebr);
            printf("-Espacio Libre: %i\n",espaciolibre);
            printf("Inicio: %i\n",inicio);
            printf("Final: %i\n",fin);
            
            printf("************************************************************ \n");
            printf("*********Numero de Particiones Logicas:   %i \n",NumeroDeLogicas(funcion));
            printf("************************************************************ \n");
            printf("///////////////////////Numero de Particiones Logicas por funcion:   %i \n",NumeroDeLogicas(funcion));

        }

        fclose(file2);
    }
    
 
            printf("**ERRORES ENCONTRADOS LSL::::::: %i\n",ErrorT);
            
}



//--------------------------Montar Particiones----------------------------------
void MontarParticionF1(Funcion funcion){

    int ErrorT=0;
    
    //arregla el path del archivo para encontrarlo
    //******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    
    
    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL)
    {
        printf("\nInterprete (X)#: _ ERROR_5.4 Al tratar de Acceder al Archivo \n\n\n");
        ErrorT++;
        ErrorMontar++;
    }
    else//si existe El Disco Ahora a Buscar Entre Las PRimarias
    {
        
        MbrDisco mbr2;
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        int partcionborrar=-1;
        int z=0;
        int k=0;
        int l=0;
        //recorre arreglo de particiones primarias buscando la particion
        for(z=0;z<4;z++)
        {
            //mbr2.particiones[z].part_status!='0'
            if(!strcmp(mbr2.particiones[z].part_name,funcion.name)&&mbr2.particiones[z].part_status!='0'){
                partcionborrar=z;
            }

        }
        
        if(partcionborrar>=0)
        {
            printf("\n\n*************Particion Existe En Las Primarias y Extendida\n ");
            //------------------------------------------------------------------LLAMA A MONTAR PARTICION
            MontarParticionF2(funcion);
            
        }else{
            printf("\n\n*************Particion NOOOOO Existe En Las Primarias y Extendida Verificando en Logicas.....\n ");
            int comparador=ExisteLogica(funcion.name,funcion);           
            if(comparador==0){
                
            printf("\n\n*************Particion No Existe TAmpoco en las Logicas (Finaliza cn Error)\n ");
            printf("\nInterprete (X)#: _ ERROR_5.3 Al tratar de Acceder al Archivo (no existe en las particiones Primarias , Extendidas y Logicas) \n Nombre:: %s \n",funcion.name);
            ErrorT++;
            ErrorMontar++;
            
            }else{
                
            printf("\n\n*************Particion Existe  en las Particiones Logicas \n ");
            //------------------------------------------------------------------LLAMA A MONTAR PARTICION
            MontarParticionF2(funcion);
            }
        
        }
        
        
        
        fclose(file2);
        
        
    }
    
    
    printf("\n\n *****Montado Finalizado ******\n\n");

    printf("**ERRORES ENCONTRADOS::::::: %i\n",ErrorT);
    
    
}

void MontarParticionF2(Funcion funcion){
    
//arregla el path del archivo para encontrarlo
    //******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);

    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    
   
    printf("\n-----------Path ASTERISCO= %s ------------------------------------\n" , funcion.path);
    
    char letraAasignar;
    int numeroAsignar;
    int auxLetraSeteada;//letra colocada
    
    int i;
    for(i=0; i<50; i++){

        if(montadas2[i].status==0){//hay espacio libre monta una aqui


            int auxLetraDisponible;//bandera que almacena la posicion de la letra disponible  
            int j;  
            for(j=0; j<26; j++){//------------------------------------------------for q busca letra disponible

                if(letras[j].status==1){//llena o letra utilizada  
                }else{//disponible para asignar y truena todo el for 

                auxLetraDisponible=j;    
                auxLetraSeteada=j;
                //pocicion en el arreglo de letras
                break;    

                }    
            }//-----------------------------------------------------------------------

            int tieneletra=0;//interruptor de si el disco tiene una letra ya asignada
            j=0;
            for(j=0; j<26; j++){//------------------------------------------------busca si el disco ya tiene una letra asignada------

                if(!strcmp(letras[j].pathPerteneciente,funcion.path)){// si la path de la funcion es igual a la del arreglo de letras ya tiene letra asignada

                    letraAasignar=letras[j].letra;
                    auxLetraSeteada=j;
                    tieneletra=1;//interruptor encendido 

                }    

            }//-----------------------------------------------------------------------


            if(tieneletra==1){ //si ya tiene una letra disponible
                printf("La LEtra q se Asignara es la: '%c' \n", letraAasignar);
                printf("La Posicion de La Letra Asignada: '%i' \n", auxLetraSeteada);
            }else{ //falta ponerle letra disponible
                letraAasignar=letras[auxLetraDisponible].letra;
                printf("La LEtra q Estaba Disponible y se Asigno es: '%c' \n", letraAasignar);
                printf("La Posicion de La Letra Asignada: '%i' \n", auxLetraSeteada);
                letras[auxLetraDisponible].status=1;
                strcpy(letras[auxLetraDisponible].pathPerteneciente,funcion.path);
                letras[auxLetraDisponible].pathPertenecienteP=funcion.path;

                //---llenar el arreglo de posisciones en 0
                for(j=0; j<26; j++){
                    letras[auxLetraDisponible].posiciones[j]=0;
                }     
            }



          //for para buscar el numero Disponible

            for(j=0; j<26; j++){

                if(letras[auxLetraSeteada].posiciones[j]==0){//esta vacio entonces esta posicion se puede poner

                    numeroAsignar=j+1;
                    letras[auxLetraSeteada].posiciones[j]=numeroAsignar;
                    break;

                }else{//esta lleno esta posicion no se puede poner
                }

            }

            // limpiarvar(montadas2[i].path2,100);
            limpiarvar(montadas2[i].name2,100);
            //Asigna ya Todo Asi Final
            montadas2[i].letrafinal=letraAasignar;
            montadas2[i].numerofinal=numeroAsignar;
            montadas2[i].path2=funcion.path;
            montadas2[i].status=1;
            montadas2[i].name=funcion.name;
            strcpy(montadas2[i].name2,funcion.name);
            strcpy(montadas2[i].path3,funcion.path);
            montadas2[i].id[0]='v';
            montadas2[i].id[1]='d';
            montadas2[i].id[2]=letraAasignar;




            //char c[2]=(char) (numeroAsignar + 48);

            //COLOCAR NUMERO DE LA TABLA
            char texto[2];
            sprintf(texto, "%d", numeroAsignar);

            printf("Numero A Concatenar: '%s' \n", texto);
            int k=0;
            for(k; k<2;k++){

                if(texto[k+1]==NULL){
                montadas2[i].id[3]=texto[k];
                break;
                }else{
                montadas2[i].id[3]=texto[k];
                montadas2[i].id[4]=texto[k+1];
                break;    
                }        

            }


          printf("*************************************************\n" );
          printf("Imprime Concatenada FINAL: '%s' \n", montadas2[i].id );
          printf("*************************************************\n" );
          ContadorComandosExitosos++;

          break;


        }else{//no hay espacio para montar

        }
    
    }
 
MostrarMontadas();
}

void MostrarMontadas(){
    printf("*****************************************************************************\n"); 
    printf("**********************PARTICIONES MONTADAS***********************************\n");
    printf("*****************************************************************************\n");
    int i;
    for(i=0; i<50; i++){
    
        if(montadas2[i].status==1){//es montada va :V chavo
            
        printf("\n-----------Posicion en Arreglo= %i ------------------------------------\n\n" , i);  
        printf("Particion Montada: '%s' \n",montadas2[i].name2);
        printf("ID : %s \n",montadas2[i].id);
        printf("\n");    
        printf("Path: %s \n",montadas2[i].path3);
        printf("Letra: %c \n",montadas2[i].letrafinal);
        printf("Numero: %d \n",montadas2[i].numerofinal);
        //printf("Particion Montada: '%s' \n",montadas2[i].name);
        //printf("Path: %s \n",montadas2[i].path2);
        
        printf("\n------------------------------------------------------------------------\n");
            
            
        }else{
        }
        
    }
    
    
    
}

void llenarletras(){
    
    letras[0].letra='a';
    letras[1].letra='b';
    letras[2].letra='c';
    letras[3].letra='d';
    letras[4].letra='e';
    letras[5].letra='f';
    letras[6].letra='g';
    letras[7].letra='h';
    letras[8].letra='i';
    letras[9].letra='j';
    letras[10].letra='k';
    letras[11].letra='l';
    letras[12].letra='m';
    letras[13].letra='n';
    letras[14].letra='o';
    letras[15].letra='p';
    letras[16].letra='q';
    letras[17].letra='r';
    letras[18].letra='s';
    letras[19].letra='t';
    letras[20].letra='u';
    letras[21].letra='v';
    letras[22].letra='w';
    letras[23].letra='x';
    letras[24].letra='y';
    letras[25].letra='z';
    
    int i=0;
    for(i=0; i<50; i++){
    montadas2[i].status=0;
    //strcpy(montadas2[i].path,"vacio");
    //montadas2[i].path2="vacio";
    }
    
    i=0;
    for(i=0; i<26; i++){
    letras[i].status=0;
    strcpy(letras[i].pathPerteneciente,"vacio"); 
    letras[i].pathPertenecienteP="vacio";
    
    
    }
    

        
       
        

}

void DesmontarParticion(Funcion funcion){

    int estamontada=0;
    int posDeMontada=0;
    int ErrorT=0;
    
     int i;
     for(i=0; i<50; i++){//for para verificar si esta montada la particion a desmontar
         
         if(!strcmp(montadas2[i].id,funcion.id)){      
             printf("Si esta Montada LA Particion...\n");
             posDeMontada=i;
             estamontada=1;
             break;         
         }else{    
         }
         
     }//------------------------------------------------------------------------
     
     if(estamontada==1){//si esta montada 1
         
      char letraDeLaDesmontada;
      int auxLetraSeteada;
      int tieneletra=0;
      int j=0;
      for(j=0; j<26; j++){//----------------------------------------------------busca si el disco ya tiene una letra asignada------
          
          if(strcasecmp(letras[j].pathPertenecienteP,montadas2[posDeMontada].path2)==0){// si la path de la funcion es igual a la del arreglo de letras ya tiene letra asignada
          
              letraDeLaDesmontada=letras[j].letra;
              auxLetraSeteada=j;
              tieneletra=1;
              
          }      
      }//-----------------------------------------------------------------------
    
      
        //for para buscar el numero Disponible
      
      for(j=0; j<26; j++){
          
          if(letras[auxLetraSeteada].posiciones[j]==montadas2[posDeMontada].numerofinal){//si la posicion del arreglo tinee al numero de la q eliminara
          
              letras[auxLetraSeteada].posiciones[j]=0;
              break;
              
          }else{//esta lleno esta posicion no se puede poner
          }
              
      }
      
        //DESMONTARLA
        printf("**PArticion Desmontada::::::: %s\n",montadas2[posDeMontada].name);
        printf("**PArticion ID::::::: %s\n",montadas2[posDeMontada].id);
        printf("\n\n**Desmontado Finalizado::::::: %s\n",montadas2[posDeMontada].name);
        montadas2[posDeMontada].status=0;

        
        
     }else{//sino esta montada Error 0
        printf("\n Interprete #_ ERROR_6.0(unmount1) La particion '%s' No esta Montada \n\n\n",funcion.id);
        ErrorT++;
        ErrorDesmontar++;
     }
    
    MostrarMontadas();
    
       
}

int PosicionDeMontada;//setea la posicion q tiene en la lista de montadas cada ves q entra al metodo de abajo
int EstaMontada(Funcion funcion){

    
        int estamontada=0;
    int posDeMontada=0;
    int ErrorT=0;
    
     int i;
     for(i=0; i<50; i++){//for para verificar si esta montada la particion a desmontar
         
         if(!strcmp(montadas2[i].id,funcion.id)){      
             printf("Si esta Montada LA Particion...\n");
             posDeMontada_rep=i;
             PosicionDeMontada=i;
             estamontada=1;
             break;         
         }else{    
         }
         
     }//------------------------------------------------------------------------
 
     return estamontada;
}



//--------------------------Metodos de Graficacion MBR------------------------------

void ReporteMBR_dot(Funcion funcion){
    
    limpiarvar(cadd,5000);
    limpiarvar(cadE,5000);
    
    Funcion temporal=funcion;
    char cad[5000]="digraph g {\ngraph [rankdir = \"LR\"];\nlabel= \"Reporte MBR\";\nfontsize = 20;\n";
    //concatena cadenas a cad     
    char nombreextendida[500];

    printf("\n\n**************** InforMacion de Disco ***********************\n\n");
    int ErrorT=0;

    //******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    
    if(EstaMontada(funcion)==1){
    
    int posM=posDeMontada_rep;    
    posDeMontada_rep=0; 
    
    int nombresiguales=0;
    int numeroprimarias=0;
    int numeroextendida=0;
    
    int TempPrimarias=0;
    int TempExt=0;
    
    printf("\n");
    
    
    char conc[500]="Subgraph cluster_mbr{\nrank=same;\nfontsize = 9;\nlabel=\"";
    strcat(conc,funcion.path);
    strcat(conc,"\";\nnode[shape=record, fontsize = 8,rankdir = LR];\n");
    
    strcat(cad,conc);//---------------------------------------------------------Concatena a Dot
    
    
        FILE* file2= fopen(montadas2[posM].path3, "rb+");
        if (file2==NULL){  //si no existe el archivo
            printf("\n Interprete (X)#: _ ERROR_6.1 Al tratar de Acceder al Archivo \n\n");
            ErrorReporte1++;
            
        }else{//si existe

            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
   
            char concatenadoFinal[5000]="MBR[label=\"{ ";
            char cerrartabla1[100]="}|";
            char cerrartabla2[100]="} }\"];}         ";
            
            char conc1[5000]="{<d>Nombre|<d>mbr_tamano|<d>mbr_fecha_creacion|<d>mbr_disk_signature";
            
            char conc2[5000]="{<d>Valor|<d>";
            char texto[10];
            sprintf(texto, "%d",mbr2.mbr_tamano);       
            strcat(conc2,texto);
            strcat(conc2,"|<d>");
            strcat(conc2,mbr2.mbr_fecha_creacion);
            strcat(conc2,"|<d>");
            char texto2[10];
            sprintf(texto2, "%d",mbr2.mbr_disk_signature);       
            strcat(conc2,texto2);
            
            
            printf("Asignacion:: %i",mbr2.mbr_disk_signature);
            printf("\n");
            printf("Fecha de Consulta:: %s",mbr2.mbr_fecha_creacion);
            printf("\n");
            printf("Tamaño de Unidad:: %i",mbr2.mbr_tamano);
            printf("\n\n");
            printf("----------------Particiones En Disco------------------------\n");
            
            

            char conc3[5000]=".";
            char conc4[5000]=".";
            char texto3[50];
            
            int z=0;
            for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                int k=0;
                int l=0;
                while(funcion.name[k]!=NULL){
                if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                    l++;
                }
                    k++;
                }
                
                int interruptorPrimarias=0;
                int interruptorExt=0;
                
                if(mbr2.particiones[z].part_type=='p'||mbr2.particiones[z].part_type=='P')//si el tipo es primaria
                {
                interruptorPrimarias=1;   
                char env[100]; 
                strcpy(env,mbr2.particiones[z].part_name);
                quitarComillas(env);
                printf("*Primaria, Nombre:: %s",sincomillas);
                printf(",Tamaño:: %i",mbr2.particiones[z].part_size);
                printf("\n");
                numeroprimarias++;
                
                }
                if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')//si el tipo es extendida
                {
                interruptorExt=1;
                char env4[100]; 
                strcpy(env4,mbr2.particiones[z].part_name);
                quitarComillas(env4);
                printf("*Extendida, Nombre:: %s",sincomillas);
                printf(",Tamaño:: %i",mbr2.particiones[z].part_size);
                printf("\n");
                
                //nombreextendida=mbr2.particiones[z].part_name;
                strcpy(nombreextendida,mbr2.particiones[z].part_name);
                numeroextendida++;

                }
                
                //ESCRIBIR :V
                int ind=z+1;
                
                
                if(interruptorPrimarias==1){
                    interruptorPrimarias=0;
                    //TABLA IZQUIERDA
                    //TABLA IZQUIERDA
                    strcat(conc3,"|<d>part_status_");
                    //char texto3[10];
                    sprintf(texto3, "%d",ind);       
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_type_");
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_fit_");
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_start_");
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_size_");
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_name_");
                    strcat(conc3,texto3);
                    
                    //TABLA DERECHA
                    strcat(conc4,"|<d>"); 
                    char*x=mbr2.particiones[z].part_status;
                    strcat(conc4,&x);
                    strcat(conc4,"|<d>"); 
                    char*y=mbr2.particiones[z].part_type;
                    strcat(conc4,&y);
                    strcat(conc4,"|<d>"); 
                    char*w=mbr2.particiones[z].part_fit;
                    strcat(conc4,&w);
                    strcat(conc4,"|<d>"); 
                    char texto4[10];
                    sprintf(texto4, "%d",mbr2.particiones[z].part_start);    
                    strcat(conc4,texto4);
                    strcat(conc4,"|<d>");
                    char texto5[10];
                    sprintf(texto5, "%d",mbr2.particiones[z].part_size);      
                    strcat(conc4,texto5);
                    strcat(conc4,"|<d>");
                    char env3[100]; 
                    strcpy(env3,mbr2.particiones[z].part_name);
                    quitarComillas(env3);
                    strcat(conc4,sincomillas);
                    
                
                }else if (interruptorExt==1){
                    interruptorExt=0;
                    //TABLA IZQUIERDA
                    strcat(conc3,"|<d>part_status_");
                    //char texto3[10];
                    sprintf(texto3, "%d",ind);       
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_type_");
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_fit_");
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_start_");
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_size_");
                    strcat(conc3,texto3);
                    strcat(conc3,"|<d>part_name_");
                    strcat(conc3,texto3);
                    
                    //TABLA DERECHA
                    strcat(conc4,"|<d>"); 
                    char*a=mbr2.particiones[z].part_status;
                    strcat(conc4,&a);
                    strcat(conc4,"|<d>"); 
                    char*b=mbr2.particiones[z].part_type;
                    strcat(conc4,&b);
                    strcat(conc4,"|<d>"); 
                    char*c=mbr2.particiones[z].part_fit;
                    strcat(conc4,&c);
                    strcat(conc4,"|<d>"); 
                    char texto4[10];
                    sprintf(texto4, "%d",mbr2.particiones[z].part_start);    
                    strcat(conc4,texto4);
                    strcat(conc4,"|<d>");
                    char texto5[10];
                    sprintf(texto5, "%d",mbr2.particiones[z].part_size);      
                    strcat(conc4,texto5);
                    strcat(conc4,"|<d>");
                    char env2[100]; 
                    strcpy(env2,mbr2.particiones[z].part_name);
                    quitarComillas(env2);
                    strcat(conc4,sincomillas);
                
                }else{//no hay particion aqui :v 
                
                }
            }
            
            //ESCRIBE EN DOT:::::::::::::::
            
            strcat(concatenadoFinal,conc1);
            strcat(concatenadoFinal,conc3);
            strcat(concatenadoFinal,cerrartabla1);
            strcat(concatenadoFinal,conc2);
            strcat(concatenadoFinal,conc4);
            strcat(concatenadoFinal,cerrartabla2);
            
            strcat(cad,concatenadoFinal);
            
            printf("\n::DOT:: %s",concatenadoFinal);//imprime el Dot
            
            
            printf("************************************************************ \n");
            printf("*********Numero de Particiones primarias:   %i \n",numeroprimarias);
            printf("*********Numero de PArticiones extendidas:  %i \n",numeroextendida);
            printf("************************************************************ \n");
            
            if(numeroextendida!=0){
                
                printf(":::::::::Reporte De Particion Extendida: '%s'  \n",nombreextendida);
                strcpy(funcion.path,montadas2[posM].path3);
                ReporteEBR_dot(funcion);
                
            }else{
            
                printf("--No Existe Particiones Extendidas en la Unidad \n");
                
                
            }

        }    
    fclose(file2);
    
    }else{
     printf("\n Interprete (X)#: _ ERROR_6.2_(MONTAJE) LA Particion No Esta Montada \n\n");
     ErrorReporte1++;
    }
    
    
    strcat(cad,cadE);
    strcat(cad,"\n}\n");
    
    if(ErrorT==0){
        printf("\n::DOT:: %s",cad);//imprime el Dot
        switch_mbr=1;
        limpiarvar(Dot_MBR,5000);
        strcat(Dot_MBR,cad);
        ReporteMBR_Generar(temporal);
    }else{
        printf("\n::_ VACIO Y CON ERRORES Errores= %d\n",ErrorT);
        switch_mbr=0;
    }
    
        
    
}

void ReporteEBR_dot(Funcion funcion){
    
    
  
    char cad[5000]="digraph g {\ngraph [rankdir = \"LR\"];\nlabel= \"Reporte EBR\";\nfontsize = 20;\n";

    strcat(cadE,"Subgraph ebr{");    
    int ErrorT=0;
    int nombresiguales=0;
    int numeroextendida=0;
    int idextendida=-1;
    int tamanooextendida=0;
    int inicio=-1; int fin=-1;
    char*nombreextendida;
    int contador=0;
    
    
    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL)
    {
        printf("\nInterprete (X)#: _ ERROR_6.3 Al tratar de Acceder al Archivo \n\n\n");
        ErrorReporte1++;
    }
    else
    {
        MbrDisco mbr2;
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        int z;    
        
        for(z=0;z<4;z++)
        {
            int k=0,l=0;
            while(funcion.name[k]!=NULL){
                if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                    l++;
                }k++;
            }

            if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')
            {
                numeroextendida++;
                idextendida=z;
                tamanooextendida=mbr2.particiones[z].part_size;
                nombreextendida=mbr2.particiones[z].part_name;
            }
        }

        if(nombresiguales>0){
        printf("\n Interprete (X)#: _ ERROR_6.4 Nombre de la PArticion ya Existente \n\n %s \n",funcion.name);
        ErrorT++;
        ErrorReporte1++;
        }
        else{

            int tamanoparticion=0;
            if(funcion.unit=='b'||funcion.unit=='B')
            {
                tamanoparticion=funcion.size;
            }
            else if(funcion.unit=='k'||funcion.unit=='K')
            {
                tamanoparticion=(funcion.size*1024);
            }
            else
            {
                tamanoparticion=funcion.size*(1024*1024);
            }

            int vacio=1;
            EBR ebr;
            int actual=mbr2.particiones[idextendida].part_start;
            //printf("posicion actual %i\n",actual);
            fseek(file2,actual,SEEK_SET);
            fread(&ebr, sizeof(EBR), 1, file2);
            int next=ebr.part_next;
            inicio=sizeof(EBR);

            int fin=inicio+tamanoparticion;
            //int contador=0;
            int numeroebr=0;
            int espaciolibre=mbr2.particiones[idextendida].part_size;
            espaciolibre-=32;
            do{
                if(ebr.part_next!=-1){
                    actual+=sizeof(EBR);
                    actual+=ebr.part_size;
                    //printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    next=ebr.part_next;
                    contador++;
                }
                contador++;
            }while(next!=-1);

            printf("-----------------Lista de Particiones------------------------\n");

            EBR indices[contador+1];
            contador=0;
            actual=mbr2.particiones[idextendida].part_start;
            fseek(file2,actual,SEEK_SET);
            fread(&indices[contador], sizeof(EBR), 1, file2);
            
            do{
                
                if(indices[contador].part_next!=-1){
                    //printf("contador %i\n",contador);
                    actual+=sizeof(EBR);
                    actual+=indices[contador].part_size;
                    //printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador+1], sizeof(EBR), 1, file2);
                    next=indices[contador].part_next;
                    //printf("siguiente %i\n",next);
                }else{
                    //printf("contador %i\n",contador);
                    next=-1;
                }
                contador++;
            }while(next!=-1);
            
            
            char texto3[50];
            
            char cerrartabla1[100]="}|";
            char cerrartabla2[100]="} }\"];}         \n}";

            int i=0;
            for(i=0;i<contador;i++){
                
                if(indices[i].part_start!=-1 && indices[i].part_status!='0' ){//&& indices[i].part_status!='0'
                vacio=0;
                
                int ind=i+1;
                strcat(cadE,"Subgraph cluster");
                sprintf(texto3, "%d",ind);       
                strcat(cadE,texto3);
                strcat(cadE,"{\nrank=same;\nfontsize = 9;\nlabel=\"");
                strcat(cadE,"EBR_");
                strcat(cadE,texto3);
                strcat(cadE,"\";\nnode[shape=record, fontsize = 8,rankdir = LR];\n");
                
                strcat(cadE,"EBR");
                strcat(cadE,texto3);
                strcat(cadE,"[label=\"{ ");
                
                strcat(cadE,"{<d>Nombre|<d>part_status|<d>part_fit|<d>part_start|<d>part_size|<d>part_next|<d>part_name");
                
                strcat(cadE,"}|");
                
                strcat(cadE,"{<d>Valor|<d>");
                char*popo=indices[i].part_status;
                strcat(cadE,&popo);
                strcat(cadE,"|<d>"); 
                char *popo2=indices[i].part_fit;
                strcat(cadE,&popo2); 
                strcat(cadE,"|<d>"); 
                char texto4[10];
                sprintf(texto4, "%d",indices[i].part_start);    
                strcat(cadE,texto4);
                strcat(cadE,"|<d>");
                char texto5[10];
                sprintf(texto5, "%d",indices[i].part_size);    
                strcat(cadE,texto5);
                strcat(cadE,"|<d>");
                char texto6[10];
                sprintf(texto6, "%d",indices[i].part_next);    
                strcat(cadE,texto6);
                strcat(cadE,"|<d>");
                char env[100]; 
                strcpy(env,indices[i].part_name);
                quitarComillas(env);
                strcat(cadE,sincomillas);
                strcat(cadE,"} }\"];}");
                

                
                //printf("*Nomb%s\n",indices[i].part_name);
                char env2[100]; 
                strcpy(env,indices[i].part_name);
                quitarComillas(env);

                printf("**Logica, Nombre:: %s",sincomillas);
                printf(",Tamaño:: %i",indices[i].part_size);
                printf("\n");
                printf(",Status:: %c",indices[i].part_status);
                printf("\n");
                printf(",Start:: %i",indices[i].part_start);
                printf("\n");
                printf(",Next:: %i",indices[i].part_next);
                printf("\n");
                
/*
                if(fin<=(indices[i].part_start-sizeof(EBR))){
                    break;
                }
                else
                {
                    inicio=indices[i].part_start+indices[i].part_size+sizeof(EBR);
                    fin=inicio+tamanoparticion;
                    numeroebr=i+1;
                }
                if(i==0){
                espaciolibre=espaciolibre-indices[i].part_size;
                }else{
                espaciolibre=espaciolibre-indices[i].part_size-sizeof(EBR);
                }
*/

                }
                }
            
            strcat(cadE,"\n}");
            
            //aqui envez de la funcion iba el contador :v
            printf("**************** Info ************************************** \n");
            printf("Total:::::: %i\n",NumeroDeLogicas(funcion));  
            printf("-Posicion: %i\n",numeroebr);
            printf("-Espacio Libre: %i\n",espaciolibre);
            printf("Inicio: %i\n",inicio);
            printf("Final: %i\n",fin);
            
            printf("************************************************************ \n");
            printf("*********Numero de Particiones Logicas:   %i \n",NumeroDeLogicas(funcion));
            printf("************************************************************ \n");
            printf("///////////////////////Numero de Particiones Logicas por funcion:   %i \n",NumeroDeLogicas(funcion));

        }

        fclose(file2);
    }
    
/*
            printf("\n\n *****PArticionado Logico Finalizado ******\n\n");
            printf("Numero de particiones extendidas= %i\n\n",numeroextendida);
            printf("Nombre de la Particion Extendida= %s\n\n",nombreextendida);
            printf("Numero de particiones Logicas en La Extendida= %i\n\n",contador);
            printf("**ERRORES ENCONTRADOS::::::: %i\n",ErrorT);
*/
 
            printf("**ERRORES ENCONTRADOS LSL::::::: %i\n",ErrorT);
            
            //strcat(cad,"\n}");//cerrar Documento dot
            
            if(ErrorT==0){
             printf("\n::DOT:: %s \n\n",cadE);//imprime el Dot
             //strcat(Dot_EBR,cad);
             //Dot_EBR=cad;
             //switch_ebr=1;
             //ReporteEBR_Generar();
            }else{
                 printf("Estructura con Errores :S\n\n");
                 switch_ebr=0;
            }            
           
}

void ReporteMBR_Generar (Funcion funcion){
    
    int ErrorT=0;

    /******************* Quita "comillas" en la path **************************/
    char pathauxiliar[500];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[500];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
    //**************************************************************************
    
    
    //**************************************************************************
    //*******Para crear Carpetas en los Directorios si no an sido Creadas*******
    
    int indice=0;
    char carpeta1[500];
    while(funcion.path[indice]!='.')
    {
    if(funcion.path[indice]!='/')
        {
            //carpeta=ConcatenarCadenaCaracter(carpeta,pathoriginal[indice]);
            char c1[1];
            c1[0]=funcion.path[indice];
            strncat(carpeta1,c1,1);
        }
        else
        {
            strcat(finalizado,"mkdir ");
            strcat(finalizado,"\"");
            strcat(finalizado,carpeta1);
            strcat(finalizado,"\"");
            strcat(finalizado,"\n");
            strcat(finalizado,"cd ");
            strcat(finalizado,"\"");
            strcat(finalizado,carpeta1);
            strcat(finalizado,"\"");
            strcat(finalizado,"\n");
            strcat(carpeta1,"");
            limpiarvar(carpeta1,500);
            
        }
        indice++;
    }
    
    printf("\nImprimir el comando q ejecuta en la terminal si el directorio no existe: %s\n",finalizado);
    
    system(finalizado);
    
    //**************************************************************************
    
    //**************************************************************************
    
    
    char consola[200]=" ";
    FILE *flujo=fopen("/home/carlos/Escritorio/Reporte_mbr.dot","w");
    if (flujo==NULL){
        
        printf("\nInterprete (X)#: _ ERROR_6.5 Error Al Crear el ARchivo \n\n \n");
        ErrorT++;
        ErrorReporte1++;
    
    }else{
    
        if(switch_mbr==1){ //Esta Activado y Tiene el texto del dot
            
        strcat(consola,"dot -Tpdf /home/carlos/Escritorio/Reporte_mbr.dot -o");
        strcat(consola,funcion.path);
            
        fputs(Dot_MBR,flujo);//escribe..
        switch_mbr=0;//apaga el switch
        fclose(flujo);
        //system("dot -Tpdf /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_mbr.dot -o /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_mbr.pdf");
        system(consola);
        ContadorComandosExitosos++;

       
        }else{//ubo un error al generar el texto del dot
            fclose (flujo);
        }
    }
    
}


//-------------------------Metodo de Graficar DISK--------------------------------

void ReporteDiskEBR(Funcion funcion){

        
/*
    char cad[5000]="digraph g {\ngraph [rankdir = \"LR\"];\nlabel= \"Reporte EBR\";\nfontsize = 20;\n";

    strcat(cadE,"Subgraph ebr{");    
 * 
 * 
 * 
*/
    
    strcat(cadd,"subgraph cluster_0 {\nrankdir = \"RL\";\nlabel = \"LOGICAS\";");

    
    int ErrorT=0;
    int nombresiguales=0;
    //int numeroprimarias=0;
    int numeroextendida=0;
    int idextendida=-1;
    int tamanooextendida=0;
    int inicio=-1; int fin=-1;
    char*nombreextendida;
    int contador=0;
    
    
    FILE* file2= fopen(funcion.path, "rb+");
    if (file2==NULL)
    {
        printf("\nInterprete (X)#_ ERROR_6.8: disk Al tratar de Acceder al Archivo \n\n\n");
        ErrorT++;
        ErrorReporte2++;
    }
    else
    {
        MbrDisco mbr2;
        //printf("%d",ftell(file2));
        fseek(file2,0,SEEK_SET);
        fread(&mbr2, sizeof(MbrDisco), 1, file2);
        int z;
        
        
        for(z=0;z<4;z++)
        {
            int k=0,l=0;
            while(funcion.name[k]!=NULL){
                if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                    l++;
                }k++;
            }

            if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')
            {
                numeroextendida++;
                idextendida=z;
                tamanooextendida=mbr2.particiones[z].part_size;
                nombreextendida=mbr2.particiones[z].part_name;
            }
        }

        if(nombresiguales>0){
        printf("\nInterprete (X)#_ ERROR_6.9: Nombre de la PArticion ya Existente \n\n %s \n",funcion.name);
        ErrorT++;
        ErrorReporte2++;
        }
        else{

/*
            printf("particion logiaca a crear= %s \n",funcion.name);
            printf("****particion Extendida donde se Crea= %s \n",nombreextendida);
            printf("tamaño de particion extendida= %i \n",tamanooextendida);
            printf("id particion = %i \n",idextendida);
            printf("tamaño ebr: %i \n",sizeof(EBR));
*/
            int tamanoparticion=0;
            if(funcion.unit=='b'||funcion.unit=='B')
            {
                tamanoparticion=funcion.size;
            }
            else if(funcion.unit=='k'||funcion.unit=='K')
            {
                tamanoparticion=(funcion.size*1024);
            }
            else
            {
                tamanoparticion=funcion.size*(1024*1024);
            }
/*
            printf("tamaño particion: %i \n",tamanoparticion);
*/

            int vacio=1;
            EBR ebr;
            int actual=mbr2.particiones[idextendida].part_start;
            //printf("posicion actual %i\n",actual);
            fseek(file2,actual,SEEK_SET);
            fread(&ebr, sizeof(EBR), 1, file2);
            int next=ebr.part_next;
            inicio=sizeof(EBR);

            int fin=inicio+tamanoparticion;
            //int contador=0;
            int numeroebr=0;
            int espaciolibre=mbr2.particiones[idextendida].part_size;
            espaciolibre-=32;
            do{
                if(ebr.part_next!=-1){
                    actual+=sizeof(EBR);
                    actual+=ebr.part_size;
                    //printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    next=ebr.part_next;
                    contador++;
                }
                contador++;
            }while(next!=-1);

            printf("-----------------Lista de Particiones------------------------\n");

            EBR indices[contador+1];
            contador=0;
            actual=mbr2.particiones[idextendida].part_start;
            fseek(file2,actual,SEEK_SET);
            fread(&indices[contador], sizeof(EBR), 1, file2);
            do{
                //printf("------------------------------------------------------------\n");
                //printf("fit %c\n",indices[contador].part_fit);
                //printf("name %s\n",indices[contador].part_name);
                //printf("next %i\n",indices[contador].part_next);
                //printf("size %i\n",indices[contador].part_size);
                //printf("inicio %i\n",indices[contador].part_start);
                //printf("estado %c\n",indices[contador].part_status);
                //printf("------------------------------------------------------------\n");
                if(indices[contador].part_next!=-1){
                    //printf("contador %i\n",contador);
                    actual+=sizeof(EBR);
                    actual+=indices[contador].part_size;
                    //printf("posicion actual %i\n",actual);
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador+1], sizeof(EBR), 1, file2);
                    next=indices[contador].part_next;
                    //printf("siguiente %i\n",next);
                }else{
                    //printf("contador %i\n",contador);
                    next=-1;
                }
                contador++;
            }while(next!=-1);
            
            
            char texto3[50];
            
/*
            char cerrartabla1[100]="}|";
            char cerrartabla2[100]="} }\"];}         \n}";
*/

            int i=0;
            for(i=0;i<contador;i++){
                if(!strcmp(indices[i].part_name,"Espacio Libre")){
                
                    int ind=i+20;
 

                    strcat(cadd,"n_");
                    sprintf(texto3, "%d",i);       
                    strcat(cadd,texto3);
                    strcat(cadd,"[shape=\"rectangle\",label=\"EBR\"];");

                    //particion
                    strcat(cadd,"n_");
                    sprintf(texto3, "%d",ind);       
                    strcat(cadd,texto3);
                    strcat(cadd,"[shape=\"rectangle\",label=\"NOMBRE:\n");
                    strcat(cadd,indices[i].part_name);

                    strcat(cadd,"\nseze:\n");
                    sprintf(texto3, "%d",indices[i].part_size);       
                    strcat(cadd,texto3);
                    strcat(cadd,"\"];");

                    
                }
                if((indices[i].part_start!=-1 && indices[i].part_status!='0')){//&& indices[i].part_status!='0'
                vacio=0;
                
                
                int ind=i+20;
 

                strcat(cadd,"n_");
                sprintf(texto3, "%d",i);       
                strcat(cadd,texto3);
                strcat(cadd,"[shape=\"rectangle\",label=\"EBR\"];");
                
                //particion
                strcat(cadd,"n_");
                sprintf(texto3, "%d",ind);       
                strcat(cadd,texto3);
                strcat(cadd,"[shape=\"rectangle\",label=\"NOMBRE:\n");
                strcat(cadd,indices[i].part_name);
                
                strcat(cadd,"\nseze:\n");
                sprintf(texto3, "%d",indices[i].part_size);       
                strcat(cadd,texto3);
                
                strcat(cadd,"\nstart:\n");
                sprintf(texto3, "%d",indices[i].part_start);       
                strcat(cadd,texto3);
                strcat(cadd,"\nnext:\n");
                sprintf(texto3, "%d",indices[i].part_next);       
                strcat(cadd,texto3);
                strcat(cadd,"\"];");
                      
                
                //printf("*Nomb%s\n",indices[i].part_name);
                printf("**Logica, Nombre:: %s",indices[i].part_name);
                printf(",Tamaño:: %i",indices[i].part_size);
                printf("\n");
                printf(",Status:: %c",indices[i].part_status);
                printf("\n");
                printf(",Start:: %i",indices[i].part_start);
                printf("\n");
                printf(",Next:: %i",indices[i].part_next);
                printf("\n");
                
/*
                if(fin<=(indices[i].part_start-sizeof(EBR))){
                    break;
                }
                else
                {
                    inicio=indices[i].part_start+indices[i].part_size+sizeof(EBR);
                    fin=inicio+tamanoparticion;
                    numeroebr=i+1;
                }
                if(i==0){
                espaciolibre=espaciolibre-indices[i].part_size;
                }else{
                espaciolibre=espaciolibre-indices[i].part_size-sizeof(EBR);
                }
*/

                }
                }
            strcat(cadd,"\n}");
/*
            strcat(cadE,"\n}");
*/
            
            //aqui envez de la funcion iba el contador :v
            printf("**************** Info ************************************** \n");
            printf("Total:::::: %i\n",NumeroDeLogicas(funcion));  
            printf("-Posicion: %i\n",numeroebr);
            printf("-Espacio Libre: %i\n",espaciolibre);
            printf("Inicio: %i\n",inicio);
            printf("Final: %i\n",fin);
            
            printf("************************************************************ \n");
            printf("*********Numero de Particiones Logicas:   %i \n",NumeroDeLogicas(funcion));
            printf("************************************************************ \n");
            printf("///////////////////////Numero de Particiones Logicas por funcion:   %i \n",NumeroDeLogicas(funcion));

        }

        fclose(file2);
    }
    
/*
            printf("\n\n *****PArticionado Logico Finalizado ******\n\n");
            printf("Numero de particiones extendidas= %i\n\n",numeroextendida);
            printf("Nombre de la Particion Extendida= %s\n\n",nombreextendida);
            printf("Numero de particiones Logicas en La Extendida= %i\n\n",contador);
            printf("**ERRORES ENCONTRADOS::::::: %i\n",ErrorT);
*/
 
            printf("**ERRORES ENCONTRADOS LSL::::::: %i\n",ErrorT);
            
            //strcat(cad,"\n}");//cerrar Documento dot

}

void ReporteDiskMBR (Funcion funcion){
    limpiarvar(cadd,5000);
    Funcion temporal=funcion;
    int cc=0;
/*
    system("rm /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_mbr.dot");
    system("rm /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_ebr.dot");
    system("rm /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_mbr.pdf");
    system("rm /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_ebr.pdf");
*/
    int numeroextendida=0;
      strcat(cadd,"digraph g {\nnodesep=.05;rankdir=BT;node [shape=record];\nlabel= \"Disco: ");

      //char cad[5000]="digraph g {\ngraph [rankdir = \"LR\"];\nlabel= \"Reporte MBR\";\nfontsize = 20;\n";
      //concatena cadenas a cad    
    
      //strcat(cad,funcion.path);
      //printf("CONCATENAR::::::::::::::::::: %s", cad);
    
char* nombreextendida;

    printf("\n\n**************** InforMacion de Disco ***********************\n\n");
    int ErrorT=0;
    if(funcion.name[0]=='\"')
    {
//        funcion.name++;
        int r=0;
        while(funcion.name[r]!='\"')
        {
            r++;
        }
        funcion.name[r]='\0';
    }
    
    
    if(EstaMontada(funcion)==1){
    
    int posM=posDeMontada_rep;    
    posDeMontada_rep=0; 
    
        
//******************* Quita "comillas" en la path **************************
    char pathauxiliar[100];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[100];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
  //**************************************************************************
    
    
    
/*
    char conc[500]="Subgraph cluster_mbr{\nrank=same;\nfontsize = 9;\nlabel=\"";
    strcat(conc,pathoriginal);
    strcat(conc,"\";\nnode[shape=record, fontsize = 8,rankdir = LR];\n");
    
    strcat(cad,conc);//---------------------------------------------------------Concatena a Dot
*/
    
    
        FILE* file2= fopen(montadas2[posM].path3, "rb+");
        if (file2==NULL){  //si no existe el archivo
            printf("\nInterprete (X)#_ ERROR_7.0 Al tratar de Acceder al Archivo \n\n");
            ErrorT++;
            ErrorReporte2++;
            
        }else{//si existe

            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
            
//MBR[label="{ {<d>1111|<d>22222|<d>33333|<da>44444|<d>55555}|{<data0>data0|<data1>data1|<data2>data2|<data3>data3|<data4>data4} }"];
   
/*
            char concatenadoFinal[5000]="MBR[label=\"{ ";
            
            
            char cerrartabla1[100]="}|";
            char cerrartabla2[100]="} }\"];}         ";
            
            char conc1[5000]="{<d>Nombre|<d>mbr_tamano|<d>mbr_fecha_creacion|<d>mbr_disk_signature";
            
            char conc2[5000]="{<d>Valor|<d>";
            char texto[10];
            sprintf(texto, "%d",mbr2.mbr_tamano);       
            strcat(conc2,texto);
            strcat(conc2,"|<d>");
            strcat(conc2,mbr2.mbr_fecha_creacion);
            strcat(conc2,"|<d>");
            char texto2[10];
            sprintf(texto2, "%d",mbr2.mbr_disk_signature);       
            strcat(conc2,texto2);
*/
            
            strcat(cadd,montadas2[posM].path3);
            strcat(cadd," \";\nfontsize = 20; subgraph cluster0{\n");
            
            printf("Asignacion:: %i",mbr2.mbr_disk_signature);
            printf("\n");
            printf("Fecha de Consulta:: %s",mbr2.mbr_fecha_creacion);
            printf("\n");
            printf("Tamaño de Unidad:: %i",mbr2.mbr_tamano);
            printf("\n\n");
            printf("----------------Particiones En Disco------------------------\n");
            
            
                        strcat(cadd,"\nlabel=\"PARTICIONES\";\n");
            strcat(cadd,"node2[label=\"<f0> MBR");
            strcat(cadd,"ID:");
            
            
            char texto[10];
            sprintf(texto, "%d",mbr2.mbr_disk_signature);
            strcat(cadd,texto);
            
            strcat(cadd,"TAmaño:");
            char texto2[10];
            sprintf(texto2, "%d",mbr2.mbr_tamano);
            strcat(cadd,texto2);
            
            strcat(cadd,"Fecha:");
            strcat(cadd,mbr2.mbr_fecha_creacion);
            strcat(cadd,"\", height=1];");
/*
            
            char conc3[5000]=".";
            char conc4[5000]=".";
            char texto3[50];
*/
            
                int nombresiguales=0;
    int numeroprimarias=0;
    int numeroextendida=0;
    
    int TempPrimarias=0;
    int TempExt=0;
    
            
            int z=0;
            for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                int k=0;
                int l=0;
                while(funcion.name[k]!=NULL){
                if(mbr2.particiones[z].part_name[k]==funcion.name[k]){
                    l++;
                }
                    k++;
                }
                
                int interruptorPrimarias=0;
                int interruptorExt=0;
                
                if(mbr2.particiones[z].part_type=='p'||mbr2.particiones[z].part_type=='P')//si el tipo es primaria
                {
                interruptorPrimarias=1;    
                printf("*Primaria, Nombre:: %s",mbr2.particiones[z].part_name);
                printf(",Tamaño:: %i",mbr2.particiones[z].part_size);
                printf("\n");
                numeroprimarias++;
                
                
                strcat(cadd,"node");
                char texto4[10];
                sprintf(texto4, "%d",cc);
                strcat(cadd,texto4);
                
                
                strcat(cadd,"[label=\"<f0>Part:");
                strcat(cadd,mbr2.particiones[z].part_name);
                strcat(cadd," size:");
                char texto3[10];
                sprintf(texto3, "%d",mbr2.particiones[z].part_size);
                strcat(cadd,texto3);
                strcat(cadd," Tipo: Primaria ");
                strcat(cadd,"\",height=1];");
                
                

                
                cc++;
                }else if(mbr2.particiones[z].part_type=='e'||mbr2.particiones[z].part_type=='E')//si el tipo es extendida
                {
                interruptorExt=1;
                printf("*Extendida, Nombre:: %s",mbr2.particiones[z].part_name);
                printf(",Tamaño:: %i",mbr2.particiones[z].part_size);
                printf("\n");
                
                nombreextendida=mbr2.particiones[z].part_name;
                numeroextendida++;
                
                strcat(cadd,"node");
                char texto4[10];
                sprintf(texto4, "%d",cc);
                strcat(cadd,texto4);
                
                
                strcat(cadd,"[label=\"<f0>Part:");
                strcat(cadd,mbr2.particiones[z].part_name);
                strcat(cadd," size:");
                char texto3[10];
                sprintf(texto3, "%d",mbr2.particiones[z].part_size);
                strcat(cadd,texto3);
                strcat(cadd," Tipo: Extendida ");
                strcat(cadd,"\",height=1];");
                cc++;
                
                }else{
                 strcat(cadd,"node");
                char texto4[10];
                sprintf(texto4, "%d",cc);
                strcat(cadd,texto4);
                
                
                strcat(cadd,"[label=\"<f0>Part:Libre");
                
                strcat(cadd," size:");
                char texto3[10];
                sprintf(texto3, "%d",mbr2.particiones[z].part_size);
                strcat(cadd,texto3);
                strcat(cadd," Tipo: Libre ");
                strcat(cadd,"\",height=1];");
                
                

                
                cc++;
                }
                
/*
                
*/
            }
            
            
            
            
            
            //ESCRIBE EN DOT:::::::::::::::
            
/*
            strcat(concatenadoFinal,conc1);
            strcat(concatenadoFinal,conc3);
            strcat(concatenadoFinal,cerrartabla1);
            strcat(concatenadoFinal,conc2);
            strcat(concatenadoFinal,conc4);
            strcat(concatenadoFinal,cerrartabla2);
            
            strcat(cad,concatenadoFinal);
            
            printf("\n::DOT:: %s",concatenadoFinal);//imprime el Dot
*/
            
            
            printf("************************************************************ \n");
            //printf("*********Numero de Particiones primarias:   %i \n",numeroprimarias);
            //printf("*********Numero de PArticiones extendidas:  %i \n",numeroextendida);
            printf("************************************************************ \n");
            
            if(numeroextendida!=0){
                
                printf(":::::::::Reporte De Particion Extendida: '%s'  \n",nombreextendida);
                //funcion.path=montadas2[posM].path2;
                strcpy(funcion.path,montadas2[posM].path3);
                lsl(funcion);
                ReporteDiskEBR(funcion);
                
            }else{
            
                printf("--No Existe Particiones Extendidas en la Unidad \n");
                
            }

        }    
    fclose(file2);
    
    }else{
     printf("\nInterprete (X)#: _ ERROR_7.1 LA Particion No Esta Montada \n\n");
            ErrorT++;
            ErrorReporte2++;
    }
    
    
/*
    strcat(cad,cadE);
    strcat(cad,"\n}\n");
*/
    strcat(cadd,"\n}\n}");
    if(ErrorT==0){
        printf("\n::DOT:: %s",cadd);//imprime el Dot
        switch_mbr=1;
/*
        strcat(Dot_MBR,cad);
*/
        ReporteDisk_Generar(temporal);
    }else{
        printf("\n::VACIO Y CON ERRORES Errores= %d\n",ErrorT);
        switch_mbr=0;
    }
  

}

void ReporteDisk_Generar(Funcion funcion){
    int ErrorT=0;
    
    /******************* Quita "comillas" en la path **************************/
    char pathauxiliar[500];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[500];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
    //**************************************************************************
    
    
    //**************************************************************************
    //*******Para crear Carpetas en los Directorios si no an sido Creadas*******
    
    int indice=0;
    char carpeta2[500];
    while(funcion.path[indice]!='.')
    {
    if(funcion.path[indice]!='/')
        {
            //carpeta=ConcatenarCadenaCaracter(carpeta,pathoriginal[indice]);
            char c1[1];
            c1[0]=funcion.path[indice];
            strncat(carpeta2,c1,1);
        }
        else
        {
            
            strcat(finalizado,"mkdir ");
            strcat(finalizado,"\"");
            strcat(finalizado,carpeta2);
            strcat(finalizado,"\"");
            strcat(finalizado,"\n");
            strcat(finalizado,"cd ");
            strcat(finalizado,"\"");
            strcat(finalizado,carpeta2);
            strcat(finalizado,"\"");
            strcat(finalizado,"\n");
            strcat(carpeta2,"");
            limpiarvar(carpeta2,500);
            
        }
        indice++;
    }
    
    printf("\nImprimir el comando q ejecuta en la terminal si el directorio no existe: %s\n",finalizado);
    
    system(finalizado);
    
    //**************************************************************************

    
    //**************************************************************************
    
    char consola[200]=" ";
    FILE *flujo=fopen("/home/carlos/Escritorio/Reporte_disk.dot","w");
    if (flujo==NULL){
        
        printf("\nInterprete (X)#: _ ERROR_7.2 Error Al Crear el ARchivo \n\n \n");
        ErrorT++;
        ErrorReporte2++;
    
    }else{
    
        if(switch_mbr==1){ //Esta Activado y Tiene el texto del dot
            
        strcat(consola,"dot -Tpdf /home/carlos/Escritorio/Reporte_disk.dot -o");
        strcat(consola,funcion.path);
            
        fputs(cadd,flujo);//escribe..
        switch_mbr=0;//apaga el switch
        fclose(flujo);
        //system("dot -Tpdf /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_mbr.dot -o /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_mbr.pdf");
        system(consola);
        ContadorComandosExitosos++;

       
        }else{//ubo un error al generar el texto del dot
            fclose (flujo);
        }
    }
     
}

//-------------------------Metodo de Graficar bm_Block--------------------------------

void Reporte_bm_Block(Funcion funcion){
    limpiarvar(caddblock,15000);
    printf("-----------REPORTE BLOCK--------------------\n");
    int estamontada=0;
    int posDeMontada=0;
    int ErrorT=0;
    
     int i;
     for(i=0; i<50; i++){//for para verificar si esta montada la particion a desmontar
         
         if(!strcmp(montadas2[i].id,funcion.id)){      
             printf("Si esta Montada LA Particion...\n");
             posDeMontada=i;
             estamontada=1;
             break;         
         }else{    
         }
         
     }//------------------------------------------------------------------------
     if(estamontada==0){//si la particion no esta montada
     
        printf("\nInterprete #_ ERROR_10.3(Fs) La particion '%s' No esta Montada \n\n\n",funcion.id);
        ErrorT++;
        ErrorFormatear++;
         
     }else{//si la particion esta montada
        
        char path[100];
        strcpy(path,montadas2[posDeMontada].path3);
        printf("PArticion a Formatear: '%s'\n",montadas2[posDeMontada].id);      
        printf("*La ID::::::::::::::: %s ::::::::::::::::\n",montadas2[posDeMontada].id);
        printf("*La Nombre De Particion****  %s **** \n",montadas2[posDeMontada].name2);
        printf("*La posicion en El Arreglo De Montadas = %i\n",posDeMontada);
        printf("*La Path del DISCO:: %s \n",montadas2[posDeMontada].path3);
        
        FILE* file2= fopen(path, "rb+");
        if (file2==NULL){  //si no existe el archivo
            printf("\nInterprete (X)#: _ ERROR_10.5(Block) Error en acceso al Archivo \n\n\n");
            ErrorT++;
            ErrorReporte3++;
        }else{ //si existe el Archivo
            
            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
            fclose(file2);
            
            printf("----------------Particiones En Disco------------------------\n");
            int z=0;
            int activador=0;
            int posPrimaria=-1;
            for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                if(!strcmp(montadas2[posDeMontada].name2,mbr2.particiones[z].part_name))//si encuentra el nombre
                {
                    activador=1;//indica q exite en las primarias
                    posPrimaria=z;//indica la posicion en las primarias
                }   
            }
            
            if(posPrimaria==-1){//es extendida y debe buscar en las logicas y crear en las logicas
                printf("\nDebe Buscar La PArticion en Las Logicas\n");
                
                int existeExtendida=0;
                int posExtendida;
                for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                    if(mbr2.particiones[z].part_type=='E'||mbr2.particiones[z].part_type=='e')//si encuentra Extendida
                    {
                        existeExtendida=1;
                        posExtendida=z;
                    }   
                }
                
                if(existeExtendida==1){//existe la particion Extendida
                    
                    int interruptorLogica=0;
                    int posEnLogicas;
                    int inicio=-1;
                    int tamanoparticion=0;
                    int vacio=1;
                    EBR ebr;
                    int actual=mbr2.particiones[posExtendida].part_start;
                    //printf("posicion actual %i\n",actual);
                    file2= fopen(path, "rb+");
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    int next=ebr.part_next;
                    inicio=sizeof(EBR);

                    int fin=inicio+tamanoparticion;
                    int contador=0;
                    int numeroebr=0;
                    int espaciolibre=mbr2.particiones[posExtendida].part_size;
                    espaciolibre-=32;
                    do{
                    if(ebr.part_next!=-1){
                        actual+=sizeof(EBR);
                        actual+=ebr.part_size;
                        printf("posicion actual %i\n",actual);
                        fseek(file2,actual,SEEK_SET);
                        fread(&ebr, sizeof(EBR), 1, file2);
                        next=ebr.part_next;
                        contador++;
                    }
                    contador++;
                    if(contador==500){
                        break;
                    }
                    }while(next!=-1);

                    printf("-----------------Lista de Particiones------------------------\n");

                    EBR indices[contador+1];
                    contador=0;
                    actual=mbr2.particiones[posExtendida].part_start;
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador], sizeof(EBR), 1, file2);
                    do{

                        if(indices[contador].part_next!=-1){

                            actual+=sizeof(EBR);
                            actual+=indices[contador].part_size;
                            fseek(file2,actual,SEEK_SET);
                            fread(&indices[contador+1], sizeof(EBR), 1, file2);
                            next=indices[contador].part_next;

                        }else{

                            next=-1;
                        }
                        contador++;
                    }while(next!=-1);

                    char a[100];
                    int i=0;
                    for(i=0;i<contador;i++){
                        if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0'
                        vacio=0;

                        if(!strcmp(montadas2[posDeMontada].name2,indices[i].part_name) && indices[i].part_status!='0'){

                            interruptorLogica=1;
                            posEnLogicas=i;
                            
                        }
    
                        }
                        }
                    //FIN DE BUSCAR EN LAS LOGICAS
                    
                    if(interruptorLogica==0){
                        printf("\nInterprete (X)#: _ ERROR_10.5(Fs) Error No Existe La PArticion Ni En Primarias Ni En Logicas \n\n\n");
                        ErrorT++;
                        ErrorFormatear++;
                    }else{// si existe en las logicas--------------------------------------------------LOGICAS
                    
                        //indices[posEnLogicas].part_start;
                        
                        //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",indices[posEnLogicas].part_name);
                int Nestructuras=TamaEC(indices[posEnLogicas].part_size);
                
                //-----------------------Metodo para llenar Bitmap------------
                    Bitmap bitmap2;
                    file2= fopen(path, "rb+");
                    int inicioBitmap=indices[posEnLogicas].part_start;
                    int finalBitmap=indices[posEnLogicas].part_start+(Nestructuras*sizeof(Bitmap));
                    printf("Inicio de La Particion= '%i' \n",inicioBitmap);
                    printf("Final del Arreglo de Bitmaps=  '%i' \n",finalBitmap);
                    
                    int contador=1;
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fread(&bitmap2, sizeof(Bitmap), 1, file2);
                        if(contador==20){
                           
                            char texto2[10];
                            sprintf(texto2, "%d",bitmap2.bit);
                            strcat(caddblock,texto2);
                            strcat(caddblock,"\n");
                            
                            contador=1;
                        }else{
                            char texto2[10];
                            sprintf(texto2, "%d",bitmap2.bit);
                            strcat(caddblock,texto2);
                            strcat(caddblock," , ");
                            contador++;
                        }
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    GenerarReporte_bm_Block(funcion);
                

                    
                    
                     
                    }//fin si existe en las logicas    
                    
                }else{//No existe
                    
                    printf("\nInterprete (X)#: _ ERROR_10.5(Fs) Error No Existe Una Particion Extendida \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                    
                }
                
            }else{// es Particion PRimaria
                
                if(mbr2.particiones[posPrimaria].formateada!=1){
                    printf("\nInterprete (X)#: _ ERROR_10.5(Fs) No a Sido Formateada No hay Sistema \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                }else{
                //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",mbr2.particiones[posPrimaria].part_name);
                int Nestructuras=TamaEC(mbr2.particiones[posPrimaria].part_size);
                
                    //-----------------------Metodo para llenar Bitmap------------
                    Bitmap bitmap;
                    file2= fopen(path, "rb+");
                    int inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                    int finalBitmap=mbr2.particiones[posPrimaria].part_start+(Nestructuras*sizeof(Bitmap));
                    printf("Inicio de La Particion= '%i' \n",inicioBitmap);
                    printf("Final del Arreglo de Bitmaps=  '%i' \n",finalBitmap);
                    
                    int contador=1;
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fread(&bitmap, sizeof(Bitmap), 1, file2);
                        if(contador==20){
                           
                            char texto2[10];
                            sprintf(texto2, "%d",bitmap.bit);
                            strcat(caddblock,texto2);
                            strcat(caddblock,"\n");
                            
                            contador=1;
                        }else{
                            char texto2[10];
                            sprintf(texto2, "%d",bitmap.bit);
                            strcat(caddblock,texto2);
                            strcat(caddblock," , ");
                            contador++;
                        }
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    GenerarReporte_bm_Block(funcion);
                
                
                
                
                }//fin si es formateada o no 
                
            }//fin de es primaria o logica
            
        }//fin existencia de Archivo
     
     }//fin si esta montada

}

void GenerarReporte_bm_Block(Funcion funcion){
    
    int ErrorT=0;
    
    /******************* Quita "comillas" en la path **************************/
    char pathauxiliar[500];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[500];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
    //**************************************************************************
    
    
    //**************************************************************************
    //*******Para crear Carpetas en los Directorios si no an sido Creadas*******
    
    int indice=0;
    char carpeta3[500];
    while(funcion.path[indice]!='.')
    {
    if(funcion.path[indice]!='/')
        {
            //carpeta=ConcatenarCadenaCaracter(carpeta,pathoriginal[indice]);
            char c1[1];
            c1[0]=funcion.path[indice];
            strncat(carpeta3,c1,1);
        }
        else
        {
            
            strcat(finalizado,"mkdir ");
            strcat(finalizado,"\"");
            strcat(finalizado,carpeta3);
            strcat(finalizado,"\"");
            strcat(finalizado,"\n");
            strcat(finalizado,"cd ");
            strcat(finalizado,"\"");
            strcat(finalizado,carpeta3);
            strcat(finalizado,"\"");
            strcat(finalizado,"\n");
            strcat(carpeta3,"");
            limpiarvar(carpeta3,500);
            
        }
        indice++;
    }
    
    printf("\nImprimir el comando q ejecuta en la terminal si el directorio no existe: %s\n",finalizado);
    
    system(finalizado);
    
    //**************************************************************************

    
    //**************************************************************************
    FILE *flujo=fopen(funcion.path,"w");
    
    if (flujo==NULL){
        
        printf("\nInterprete (X)#: _ ERROR_7.2(REporte Block) Error Al Crear el ARchivo \n\n \n");
        ErrorT++;
        ErrorReporte3++;
    
    }else{
        fputs(caddblock,flujo);//escribe.
        fclose(flujo);
    }

}



//-------------------------Metodos de MKFS --------------------------------

void Formatear(Funcion funcion){
    
    printf("-----------FORMATEAR PARTICION--------------------\n");
    int estamontada=0;
    int posDeMontada=0;
    int ErrorT=0;
    
     int i;
     for(i=0; i<50; i++){//for para verificar si esta montada la particion a desmontar
         
         if(!strcmp(montadas2[i].id,funcion.id)){      
             printf("Si esta Montada LA Particion...\n");
             posDeMontada=i;
             estamontada=1;
             break;         
         }else{    
         }
         
     }//------------------------------------------------------------------------
     
     if(estamontada==0){//si la particion no esta montada
     
        printf("\nInterprete #_ ERROR_10.3(Fs) La particion '%s' No esta Montada \n\n\n",funcion.id);
        ErrorT++;
        ErrorFormatear++;
         
     }else{//si la particion esta montada
        
        char path[100];
        strcpy(path,montadas2[posDeMontada].path3);
        printf("PArticion a Formatear: '%s'\n",montadas2[posDeMontada].id);      
        printf("*La ID::::::::::::::: %s ::::::::::::::::\n",montadas2[posDeMontada].id);
        printf("*La Nombre De Particion****  %s **** \n",montadas2[posDeMontada].name2);
        printf("*La posicion en El Arreglo De Montadas = %i\n",posDeMontada);
        printf("*La Path del DISCO:: %s \n",montadas2[posDeMontada].path3);
        
        FILE* file2= fopen(path, "rb+");
        if (file2==NULL){  //si no existe el archivo
            printf("\nInterprete (X)#: _ ERROR_10.5(Fs) Error en acceso al Archivo \n\n\n");
            ErrorT++;
            ErrorFormatear++;
        }else{ //si existe el Archivo
            
            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
            fclose(file2);
            
            printf("----------------Particiones En Disco------------------------\n");
            int z=0;
            int activador=0;
            int posPrimaria=-1;
            for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                if(!strcmp(montadas2[posDeMontada].name2,mbr2.particiones[z].part_name))//si encuentra el nombre
                {
                    activador=1;//indica q exite en las primarias
                    posPrimaria=z;//indica la posicion en las primarias
                }   
            }
            
            if(posPrimaria==-1){//es extendida y debe buscar en las logicas y crear en las logicas
                printf("\nDebe Buscar La PArticion en Las Logicas\n");
                
                int existeExtendida=0;
                int posExtendida;
                for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                    if(mbr2.particiones[z].part_type=='E'||mbr2.particiones[z].part_type=='e')//si encuentra Extendida
                    {
                        existeExtendida=1;
                        posExtendida=z;
                    }   
                }
                
                if(existeExtendida==1){//existe la particion Extendida
                    
                    int interruptorLogica=0;
                    int posEnLogicas;
                    int inicio=-1;
                    int tamanoparticion=0;
                    int vacio=1;
                    EBR ebr;
                    int actual=mbr2.particiones[posExtendida].part_start;
                    //printf("posicion actual %i\n",actual);
                    file2= fopen(path, "rb+");
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    int next=ebr.part_next;
                    inicio=sizeof(EBR);

                    int fin=inicio+tamanoparticion;
                    int contador=0;
                    int numeroebr=0;
                    int espaciolibre=mbr2.particiones[posExtendida].part_size;
                    espaciolibre-=32;
                    do{
                    if(ebr.part_next!=-1){
                        actual+=sizeof(EBR);
                        actual+=ebr.part_size;
                        printf("posicion actual %i\n",actual);
                        fseek(file2,actual,SEEK_SET);
                        fread(&ebr, sizeof(EBR), 1, file2);
                        next=ebr.part_next;
                        contador++;
                    }
                    contador++;
                    if(contador==500){
                        break;
                    }
                    }while(next!=-1);

                    printf("-----------------Lista de Particiones------------------------\n");

                    EBR indices[contador+1];
                    contador=0;
                    actual=mbr2.particiones[posExtendida].part_start;
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador], sizeof(EBR), 1, file2);
                    do{

                        if(indices[contador].part_next!=-1){

                            actual+=sizeof(EBR);
                            actual+=indices[contador].part_size;
                            fseek(file2,actual,SEEK_SET);
                            fread(&indices[contador+1], sizeof(EBR), 1, file2);
                            next=indices[contador].part_next;

                        }else{

                            next=-1;
                        }
                        contador++;
                    }while(next!=-1);

                    char a[100];
                    int i=0;
                    for(i=0;i<contador;i++){
                        if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0'
                        vacio=0;

                        if(!strcmp(montadas2[posDeMontada].name2,indices[i].part_name) && indices[i].part_status!='0'){

                            interruptorLogica=1;
                            posEnLogicas=i;
                            
                        }
    
                        }
                        }
                    //FIN DE BUSCAR EN LAS LOGICAS
                    
                    if(interruptorLogica==0){
                        printf("\nInterprete (X)#: _ ERROR_10.5(Fs) Error No Existe La PArticion Ni En Primarias Ni En Logicas \n\n\n");
                        ErrorT++;
                        ErrorFormatear++;
                    }else{// si existe en las logicas--------------------------------------------------LOGICAS
                    
                        //indices[posEnLogicas].part_start;
                        
                        //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",indices[posEnLogicas].part_name);
                int Nestructuras=TamaEC(indices[posEnLogicas].part_size);
                
                
                
                
                //llenando el arreglo de bitmaps en base al modo fast o full
                if(!strcmp(funcion.typeFormatear,"fast")){//si el formateo es en modo fast
                    
                    printf("---------------------METODO A FORMATEAR = 'FAST'------------------- \n");
                    //-----------------------Metodo para llenar Bitmap------------
                    Bitmap bitmap;
                    file2= fopen(path, "rb+");
                    int inicioBitmap=indices[posEnLogicas].part_start;
                    int finalBitmap=indices[posEnLogicas].part_start+(Nestructuras*sizeof(Bitmap));
                    printf("Inicio de La Particion= '%i' \n",inicioBitmap);
                    printf("Final del Arreglo de Bitmaps=  '%i' \n",finalBitmap);
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        bitmap.bit=0;
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fwrite(&bitmap, sizeof(Bitmap), 1, file2);
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    fclose(file2);
                    
                    inicioBitmap=indices[posEnLogicas].part_start;
                    Bitmap b;
                    file2= fopen(path, "rb+");  
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fread(&b, sizeof(Bitmap), 1, file2);
                        printf("Dato del Bitmap [%i] =",i);
                        printf(" '%i'\n",b.bit);
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    fclose(file2);
                    //-----------------------------------------------------------
                    
                    
                }else if (!strcmp(funcion.typeFormatear,"full")){ // si el formateo es en modo full
                
                    printf("---------------------METODO A FORMATEAR = 'FULL'------------------- \n");
                    //-----------------------Metodo para llenar Bitmap------------
                    Bitmap bitmap;
                    file2= fopen(path, "rb+");
                    int inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                    int finalBitmap=mbr2.particiones[posPrimaria].part_start+(Nestructuras*sizeof(Bitmap));
                    printf("Inicio de La Particion= '%i' \n",inicioBitmap);
                    printf("Final del Arreglo de Bitmaps=  '%i' \n",finalBitmap);
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        bitmap.bit=0;
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fwrite(&bitmap, sizeof(Bitmap), 1, file2);
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    fclose(file2);
                    
                    inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                    Bitmap b;
                    file2= fopen(path, "rb+");  
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fread(&b, sizeof(Bitmap), 1, file2);
                        printf("Dato del Bitmap [%i] =",i);
                        printf(" '%i'\n",b.bit);
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    fclose(file2);
                    //-----------------------------------------------------------
                    
                    //-----------------------Metodo para llenar Bloques------------
                    int inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                    int finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                    printf("Inicio de La Parte de Bloques= '%i' \n",inicioBloques);
                    printf("Final dela parte de Bloques =  '%i' \n",finalBloques);
                    
                    Bloque bloque;
                    
                    file2= fopen(path, "rb+");
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        strcpy(bloque.nombre,"vacio");
                        strcpy(bloque.info,"vacio");
                        fseek(file2,inicioBloques,SEEK_SET);
                        fwrite(&bloque, sizeof(Bloque), 1, file2);
                        inicioBloques=inicioBloques+sizeof(Bloque);
                        
                    }
                    fclose(file2);
                    
                    printf("Final dela parte de Bloques (Despues del For)=  '%i' \n",inicioBloques);
                    inicioBloques=finalBitmap+1;
                    
                    Bloque b1;
                    file2= fopen(path, "rb+");  
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        fseek(file2,inicioBloques,SEEK_SET);
                        fread(&b1, sizeof(Bloque), 1, file2);
                        printf("Dato del Bloque [%i] =",i);
                        printf(" Nombre:'%s' ",b1.nombre);
                        printf(" Info:  '%s' \n",b1.nombre);
                        inicioBloques=inicioBloques+sizeof(Bloque);
                        
                    }
                    fclose(file2);
                    //-----------------------------------------------------------
                    
                    file2= fopen(path, "rb+");  
                    mbr2.particiones[posPrimaria].formateada=1;
                    fseek(file2,0,SEEK_SET);
                    fwrite(&mbr2, sizeof(MbrDisco), 1, file2);//escribiendo la estructura del MBR
                    fclose(file2);
                    
                }else{
                    printf("\nInterprete (X)#: _ ERROR_10.6(Fs) Error al Verificar si es Fast y Full \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                }        
                    }//fin si existe en las logicas    
                    
                }else{//No existe
                    
                    printf("\nInterprete (X)#: _ ERROR_10.5(Fs) Error No Existe Una Particion Extendida \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                    
                }
                
            }else{// es Particion PRimaria
                
                //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",mbr2.particiones[posPrimaria].part_name);
                int Nestructuras=TamaEC(mbr2.particiones[posPrimaria].part_size);
                
                
                
                
                //llenando el arreglo de bitmaps en base al modo fast o full
                if(!strcmp(funcion.typeFormatear,"fast")){//si el formateo es en modo fast
                    
                    printf("---------------------METODO A FORMATEAR = 'FAST'------------------- \n");
                    //-----------------------Metodo para llenar Bitmap------------
                    Bitmap bitmap;
                    file2= fopen(path, "rb+");
                    int inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                    int finalBitmap=mbr2.particiones[posPrimaria].part_start+(Nestructuras*sizeof(Bitmap));
                    printf("Inicio de La Particion= '%i' \n",inicioBitmap);
                    printf("Final del Arreglo de Bitmaps=  '%i' \n",finalBitmap);
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        bitmap.bit=0;
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fwrite(&bitmap, sizeof(Bitmap), 1, file2);
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    fclose(file2);
                    
                    inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                    Bitmap b;
                    file2= fopen(path, "rb+");  
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fread(&b, sizeof(Bitmap), 1, file2);
                        printf("Dato del Bitmap [%i] =",i);
                        printf(" '%i'\n",b.bit);
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    fclose(file2);
                    //-----------------------------------------------------------
                    
                    file2= fopen(path, "rb+");  
                    mbr2.particiones[posPrimaria].formateada=1;
                    fseek(file2,0,SEEK_SET);
                    fwrite(&mbr2, sizeof(MbrDisco), 1, file2);//escribiendo la estructura del MBR
                    fclose(file2);
                    
                }else if (!strcmp(funcion.typeFormatear,"full")){ // si el formateo es en modo full
                
                    printf("---------------------METODO A FORMATEAR = 'FULL'------------------- \n");
                    //-----------------------Metodo para llenar Bitmap------------
                    Bitmap bitmap;
                    file2= fopen(path, "rb+");
                    int inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                    int finalBitmap=mbr2.particiones[posPrimaria].part_start+(Nestructuras*sizeof(Bitmap));
                    printf("Inicio de La Particion= '%i' \n",inicioBitmap);
                    printf("Final del Arreglo de Bitmaps=  '%i' \n",finalBitmap);
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        bitmap.bit=0;
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fwrite(&bitmap, sizeof(Bitmap), 1, file2);
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    fclose(file2);
                    
                    inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                    Bitmap b;
                    file2= fopen(path, "rb+");  
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        fseek(file2,inicioBitmap,SEEK_SET);
                        fread(&b, sizeof(Bitmap), 1, file2);
                        printf("Dato del Bitmap [%i] =",i);
                        printf(" '%i'\n",b.bit);
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);
                        
                    }
                    fclose(file2);
                    //-----------------------------------------------------------
                    
                    //-----------------------Metodo para llenar Bloques------------
                    int inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                    int finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                    printf("Inicio de La Parte de Bloques= '%i' \n",inicioBloques);
                    printf("Final dela parte de Bloques =  '%i' \n",finalBloques);
                    
                    Bloque bloque;
                    
                    file2= fopen(path, "rb+");
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        strcpy(bloque.nombre,"vacio");
                        strcpy(bloque.info,"vacio");
                        fseek(file2,inicioBloques,SEEK_SET);
                        fwrite(&bloque, sizeof(Bloque), 1, file2);
                        inicioBloques=inicioBloques+sizeof(Bloque);
                        
                    }
                    fclose(file2);
                    
                    printf("Final dela parte de Bloques (Despues del For)=  '%i' \n",inicioBloques);
                    inicioBloques=finalBitmap+1;
                    
                    Bloque b1;
                    file2= fopen(path, "rb+");  
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps
                        
                        fseek(file2,inicioBloques,SEEK_SET);
                        fread(&b1, sizeof(Bloque), 1, file2);
                        printf("Dato del Bloque [%i] =",i);
                        printf(" Nombre:'%s' ",b1.nombre);
                        printf(" Info:  '%s' \n",b1.nombre);
                        inicioBloques=inicioBloques+sizeof(Bloque);
                        
                    }
                    fclose(file2);
                    //-----------------------------------------------------------
                    
                    file2= fopen(path, "rb+");  
                    mbr2.particiones[posPrimaria].formateada=1;
                    fseek(file2,0,SEEK_SET);
                    fwrite(&mbr2, sizeof(MbrDisco), 1, file2);//escribiendo la estructura del MBR
                    fclose(file2);
                    
                }else{
                    printf("\nInterprete (X)#: _ ERROR_10.6(Fs) Error al Verificar si es Fast y Full \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                }//fin del verificador de fast y full
                
            }//fin de es primaria o logica
            
        }//fin existencia de Archivo
     
     }//fin si esta montada
     

}

int  TamaEC(int Tparticion){
    
    int Tbloque=sizeof(Bloque);
    int Tbitmap=sizeof(Bitmap);
    
    printf(":::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: \n");
    printf("1) Tamaño de la estructura Bloque:::::::::::::::::::::::::: %i bytes\n",Tbloque);
    printf("1) Tamaño de la estructura Bitmap:::::::::::::::::::::::::: %i bytes\n",Tbitmap);
    printf("1) Tamaño Del Disco:::::::::::::::::::::::::::::::::::::::: %i bytes\n",Tparticion);
    
    int n;
    n=((Tparticion)/(Tbloque+Tbitmap));
    
    printf("\n\n Numero de estructuras:::::::::::::::::::::::::: %i \n",n);
    
    return n;
}

//-------------------------Metodos de MKFILE --------------------------------

void CrearArchivo(Funcion funcion){
    printf("-----------Crear ARchivo--------------------\n");
    int estamontada=0;
    int posDeMontada=0;
    int ErrorT=0;
    
     int i;
     for(i=0; i<50; i++){//for para verificar si esta montada la particion a desmontar
         
         if(!strcmp(montadas2[i].id,funcion.id)){      
             printf("Si esta Montada LA Particion...\n");
             posDeMontada=i;
             estamontada=1;
             break;         
         }else{    
         }
         
     }//------------------------------------------------------------------------
     
     if(estamontada==0){//si la particion no esta montada
     
        printf("\nInterprete #_ ERROR_10.3(Mkfile) La particion '%s' No esta Montada \n\n\n",funcion.id);
        ErrorT++;
        ErrorFormatear++;
         
     }else{//si la particion esta montada
         
         char path[100];
        strcpy(path,montadas2[posDeMontada].path3);
        printf("PArticion a Formatear: '%s'\n",montadas2[posDeMontada].id);      
        printf("*La ID::::::::::::::: %s ::::::::::::::::\n",montadas2[posDeMontada].id);
        printf("*La Nombre De Particion****  %s **** \n",montadas2[posDeMontada].name2);
        printf("*La posicion en El Arreglo De Montadas = %i\n",posDeMontada);
        printf("*La Path del DISCO:: %s \n",montadas2[posDeMontada].path3);
        
        FILE* file2= fopen(path, "rb+");
        if (file2==NULL){  //si no existe el archivo
            printf("\nInterprete (X)#: _ ERROR_10.5(Mkfile) Error en acceso al Archivo \n\n\n");
            ErrorT++;
            ErrorFormatear++;
        }else{ //si existe el Archivo
            
            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
            fclose(file2);
            
            printf("----------------Particiones En Disco------------------------\n");
            int z=0;
            int activador=0;
            int posPrimaria=-1;
            for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                if(!strcmp(montadas2[posDeMontada].name2,mbr2.particiones[z].part_name))//si encuentra el nombre
                {
                    activador=1;//indica q exite en las primarias
                    posPrimaria=z;//indica la posicion en las primarias
                }   
            }
            
            if(posPrimaria==-1){//es extendida y debe buscar en las logicas y crear en las logicas
                printf("\nDebe Buscar La PArticion en Las Logicas\n");
                
                int existeExtendida=0;
                int posExtendida;
                for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                    if(mbr2.particiones[z].part_type=='E'||mbr2.particiones[z].part_type=='e')//si encuentra Extendida
                    {
                        existeExtendida=1;
                        posExtendida=z;
                    }   
                }
                
                if(existeExtendida==1){//existe la particion Extendida
                    
                    int interruptorLogica=0;
                    int posEnLogicas;
                    int inicio=-1;
                    int tamanoparticion=0;
                    int vacio=1;
                    EBR ebr;
                    int actual=mbr2.particiones[posExtendida].part_start;
                    //printf("posicion actual %i\n",actual);
                    file2= fopen(path, "rb+");
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    int next=ebr.part_next;
                    inicio=sizeof(EBR);

                    int fin=inicio+tamanoparticion;
                    int contador=0;
                    int numeroebr=0;
                    int espaciolibre=mbr2.particiones[posExtendida].part_size;
                    espaciolibre-=32;
                    do{
                    if(ebr.part_next!=-1){
                        actual+=sizeof(EBR);
                        actual+=ebr.part_size;
                        printf("posicion actual %i\n",actual);
                        fseek(file2,actual,SEEK_SET);
                        fread(&ebr, sizeof(EBR), 1, file2);
                        next=ebr.part_next;
                        contador++;
                    }
                    contador++;
                    if(contador==500){
                        break;
                    }
                    }while(next!=-1);

                    printf("-----------------Lista de Particiones------------------------\n");

                    EBR indices[contador+1];
                    contador=0;
                    actual=mbr2.particiones[posExtendida].part_start;
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador], sizeof(EBR), 1, file2);
                    do{

                        if(indices[contador].part_next!=-1){

                            actual+=sizeof(EBR);
                            actual+=indices[contador].part_size;
                            fseek(file2,actual,SEEK_SET);
                            fread(&indices[contador+1], sizeof(EBR), 1, file2);
                            next=indices[contador].part_next;

                        }else{

                            next=-1;
                        }
                        contador++;
                    }while(next!=-1);

                    char a[100];
                    int i=0;
                    for(i=0;i<contador;i++){
                        if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0'
                        vacio=0;

                        if(!strcmp(montadas2[posDeMontada].name2,indices[i].part_name) && indices[i].part_status!='0'){

                            interruptorLogica=1;
                            posEnLogicas=i;
                            
                        }
    
                        }
                        }
                    //FIN DE BUSCAR EN LAS LOGICAS
                    
                    if(interruptorLogica==0){
                        printf("\nInterprete (X)#: _ ERROR_10.5(Fs) Error No Existe La PArticion Ni En Primarias Ni En Logicas \n\n\n");
                        ErrorT++;
                        ErrorFormatear++;
                    }else{// si existe en las logicas--------------------------------------------------LOGICAS
                    
                        //indices[posEnLogicas].part_start;
                        
                        //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",indices[posEnLogicas].part_name);
                int Nestructuras=TamaEC(indices[posEnLogicas].part_size);
                
//------------------quitar comillas
                char env2[1000];
                strcpy(env2,funcion.Contenido);
                quitarComillas(env2);
                printf("El Contenido es= %s \n",sincomillas);
                //--------------------------------
                //----------contar caracteres del archivo-----
                int cont=0;            
                while(sincomillas[cont]!=NULL){
                    cont++;
                }
                printf("El Tamaño del Contenido es= %i \n",cont);
                //-----------------------------------------
                //-----Encontrar numero de bloques a usar--------
                int n=cont;
                int nbloques=0;
                if(n<50){
                    nbloques=1;
                }else{
                
                    do{
                    
                        n=n-50;
                        nbloques++;
                        
                    }while(n>50);
                    nbloques++;
                    
                }
                int nultimo=n;
                int aregloBloques[nbloques];
                char bloqueMemoria[50];
                
                
                
                printf("El Numero de Bloques a Usar por Este Archivo es= %i \n",nbloques);
                //------------------------------------------------
                //-----------Cargar Bitmap a Memoria--------------
                int inicioBitmap=indices[posEnLogicas].part_start;
                int finalBitmap=indices[posEnLogicas].part_start+(Nestructuras*sizeof(Bitmap));
                Bitmap b;
                int Bit[Nestructuras];
                FILE* file3= fopen(path, "rb+");  
                for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps

                    fseek(file3,inicioBitmap,SEEK_SET);
                    fread(&b, sizeof(Bitmap), 1, file3);
                    printf("Dato del Bitmap [%i] =",i);
                    printf(" '%i'\n",b.bit);
                    Bit[i]=b.bit;
                    inicioBitmap=inicioBitmap+sizeof(Bitmap);

                }
                fclose(file3);
                //busca si hay suficientes 0
                int x=0;
                for(int j=0; j<Nestructuras; j++){
                    if(Bit[j]==0){
                        x++;
                    }
                }
                
                if(x<nbloques){
                    
                printf("\nInterprete #_ ERROR_10.3(Mkfile) NO HAY BLOQUES DISPONIBLES \n\n\n",funcion.id);
                ErrorT++;
                ErrorFormatear++;
                    
                }else{
                    //-----------------------------------------------------------
                    //buscar que tipo d ajuste usa la Particion y setea la posicion del bitmap donde iniciara
                    int posObtenidaDeBitmap=-1;
                    int hayEspacioEnBloques=1;
                    //hacer PRIMER AJUSTE
                    if(indices[posEnLogicas].part_fit=='F'||mbr2.particiones[posPrimaria].part_fit=='f'){
                        int NoExisteEspacio=-1;

                        for(int j=0; j<Nestructuras; j++){

                            if(Bit[j]==0){//encontro un espacio
                                //verificar si hay espacio para todos sus nbloques
                                int indiceJ=j+nbloques;
                                for(int i=j; i<indiceJ; i++){//inicia desde la posicion j hasta el nbloques

                                    if(Bit[i]!=0){//si la posicion es diferente de 0 no hay espacio aqui
                                        NoExisteEspacio=1;
                                        i=indiceJ;
                                        hayEspacioEnBloques=0;
                                    }
                                }

                                if(NoExisteEspacio==-1){//significa q si hay espacio

                                    NoExisteEspacio=0;//activa la bandera para darle breake al metodoa
                                }


                            }


                            if(NoExisteEspacio==0){//entonces si hay espacio y
                                posObtenidaDeBitmap=j; //setea la posicion Inicial
                                Bit[j]=1;
                                hayEspacioEnBloques=1;
                                break;
                            }

                        }

                    //Crea el PEORR AJUSTE
                    }else if(mbr2.particiones[posPrimaria].part_fit=='W'||mbr2.particiones[posPrimaria].part_fit=='w'){

                        //encontrar el numero de Fragmentaciones en el disco
                        int contadorFragmentos=0;
                        for(int j=0; j<Nestructuras; j++){
                            if(Bit[j]==0){//encontro un espacio
                                int con=j;
                                while(con<Nestructuras&&Bit[con]!=1){
                                    con++;//aumenta el bloque
                                }
                                j=con;
                                contadorFragmentos++;
                            }
                        }
                        //crear arreglo de fragmentaciones
                        Ajuste Fragmentos[contadorFragmentos+1];
                        //setear los datos de cada fragmentacion
                        contadorFragmentos=0;
                        for(int j=0; j<Nestructuras; j++){
                            if(Bit[j]==0){//encontro un espacio
                                int con=j;
                                int contEspacios=0;
                                while(con<Nestructuras&&Bit[con]!=1){
                                    contEspacios++;//espacios 
                                    con++;//aumenta el bloque
                                }

                                Fragmentos[contadorFragmentos].NbloquesLibres=contEspacios;
                                Fragmentos[contadorFragmentos].posEnBitmap=j;
                                j=con;
                                contadorFragmentos++;
                            }
                        }


                        if(contadorFragmentos<=1){// que no haga sort
                            if(Fragmentos[0].NbloquesLibres<nbloques){//si no hay espacio
                                hayEspacioEnBloques=0;
                            }else{
                            posObtenidaDeBitmap=Fragmentos[0].posEnBitmap;
                            Bit[Fragmentos[0].posEnBitmap]=1;
                            }
                        }else{
                            //buscar la Fragmentacion mas Grande para meter en ese lugar hacemos un sort del Numero de espacios 
                            // en blanco
                            Ajuste Temp;
                            int i;
                            int j;
                            for(i=0; i<contadorFragmentos; i++){
                                for(j=0;j<contadorFragmentos-i;j++){
                                    if(Fragmentos[j].NbloquesLibres<Fragmentos[j+1].NbloquesLibres)
                                    {
                                        Temp=Fragmentos[j]; 
                                        Fragmentos[j]=Fragmentos[j+1]; 
                                        Fragmentos[j+1]=Temp;
                                    }
                                }

                            }
                            //si se ordeno la 0 deveria ser la que tiene la mallor fragmentacion
                            if(Fragmentos[0].NbloquesLibres<nbloques){//si no hay espacio
                                hayEspacioEnBloques=0;
                            }else{
                            posObtenidaDeBitmap=Fragmentos[0].posEnBitmap;
                            Bit[Fragmentos[0].posEnBitmap]=1;
                            }

                        }


                    //CRea el Mejor AJuste    
                    }else if(mbr2.particiones[posPrimaria].part_fit=='B'||mbr2.particiones[posPrimaria].part_fit=='b'){
                        //encontrar el numero de Fragmentaciones en el disco
                        int contadorFragmentos=0;
                        for(int j=0; j<Nestructuras; j++){
                            if(Bit[j]==0){//encontro un espacio
                                int con=j;
                                while(con<Nestructuras&&Bit[con]!=1){
                                    con++;//aumenta el bloque
                                }
                                j=con;
                                contadorFragmentos++;
                            }
                        }
                        //crear arreglo de fragmentaciones
                        Ajuste Fragmentos[contadorFragmentos+1];
                        //setear los datos de cada fragmentacion
                        contadorFragmentos=0;
                        for(int j=0; j<Nestructuras; j++){
                            if(Bit[j]==0){//encontro un espacio
                                int con=j;
                                int contEspacios=0;
                                while(con<Nestructuras&&Bit[con]!=1){
                                    contEspacios++;//espacios 
                                    con++;//aumenta el bloque
                                }

                                Fragmentos[contadorFragmentos].NbloquesLibres=contEspacios;
                                Fragmentos[contadorFragmentos].posEnBitmap=j;
                                j=con;
                                contadorFragmentos++;
                            }
                        }
                        
                        if(contadorFragmentos<=1){// que no haga sort
                            if(Fragmentos[0].NbloquesLibres<nbloques){//si no hay espacio
                                hayEspacioEnBloques=0;
                            }else{
                            posObtenidaDeBitmap=Fragmentos[0].posEnBitmap;
                            Bit[Fragmentos[0].posEnBitmap]=1;
                            }
                        }else{
                            //buscar la Fragmentacion mas Grande para meter en ese lugar hacemos un sort del Numero de espacios 
                            // en blanco
                            Ajuste Temp;
                            int i;
                            int j;
                            for(i=0; i<contadorFragmentos; i++){
                                for(j=0;j<contadorFragmentos-i;j++){
                                    if(Fragmentos[j].NbloquesLibres>Fragmentos[j+1].NbloquesLibres)
                                    {
                                        Temp=Fragmentos[j]; 
                                        Fragmentos[j]=Fragmentos[j+1]; 
                                        Fragmentos[j+1]=Temp;
                                    }
                                }

                            }
                            
                            for(i=0; i<=contadorFragmentos; i++){
                                
                                if(Fragmentos[i].NbloquesLibres<nbloques){
                                    hayEspacioEnBloques=0;
                                }else{
                                    Fragmentos[0]=Fragmentos[i];
                                    hayEspacioEnBloques=1;
                                    contadorFragmentos=contadorFragmentos;
                                    break;
                                }
                                
                            }
                            
                            
                            //si se ordeno la 0 deveria ser la que tiene la mallor fragmentacion
                            if(Fragmentos[0].NbloquesLibres<nbloques){//si no hay espacio
                                hayEspacioEnBloques=0;
                            }else{
                            posObtenidaDeBitmap=Fragmentos[0].posEnBitmap;
                            Bit[Fragmentos[0].posEnBitmap]=1;
                            }

                        }


                    }
                    //fin ajustes

                    if(hayEspacioEnBloques==1){
                        //llenando los 3 bloques de informacion
                        int ind=0;
                        for(int i=0; i<nbloques; i++){//recorre los 3 bloques que va usar

                            //ya encontrada una posicion en los bitmaps
                            //se busca el bloque asociado a la misma
                            int inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                            int finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                            Bloque bloque;  

                            FILE* file4= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){

                                inicioBloques=inicioBloques+sizeof(Bloque);

                            }
                            fseek(file4,inicioBloques,SEEK_SET);
                            fread(&bloque, sizeof(Bloque), 1, file4);
                            fclose(file4);
                            //ya que tenemos el bloque a utilizar seteamos el nombre
                            strcpy(bloque.nombre,funcion.name);


                            if(i==nbloques-1){//es la ultima corrida se arregla el texto
                                for(int i=0; i<nultimo; i++){
                                   bloque.info[i]=sincomillas[ind];
                                   ind++; 
                                }
                            }else{
                                for(int i=0; i<50; i++){
                                    bloque.info[i]=sincomillas[ind];
                                    ind++;
                                }
                            }
                            printf("\nIndice::: %i \n",ind); 
                            //escribe el bloque ya en el disco con sus datos
                            inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                            finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                            FILE* file5= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){
                                inicioBloques=inicioBloques+sizeof(Bloque);
                            }
                            fseek(file5,inicioBloques,SEEK_SET);
                            fwrite(&bloque, sizeof(Bloque), 1, file5);
                            fclose(file5);
                            //esbribe bitmap en el archivo
                            inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                            Bitmap b1;
                            b1.bit=1;
                            FILE* file6= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){//setea 0 en el arreglo de bitmaps
                            inicioBitmap=inicioBitmap+sizeof(Bitmap);
                            }
                            fseek(file6,inicioBitmap,SEEK_SET);
                            fwrite(&b1, sizeof(Bitmap), 1, file6);
                            fclose(file6);
                            posObtenidaDeBitmap++;
                        }



                          //muestra el reporte de los bloques XD
                            Bloque bloquer;
                            int inicioBloques=finalBitmap+1;
                            FILE*file8= fopen(path, "rb+");
                            for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps

                                fseek(file8,inicioBloques,SEEK_SET);
                                fread(&bloquer, sizeof(Bloque), 1, file8);
                                printf("\nNombre Del Bloque: %s \n",bloquer.nombre);
                                printf("Info Del Bloque:   %s \n",bloquer.info);
                                inicioBloques=inicioBloques+sizeof(Bloque);

                            }
                            fclose(file8);
                        }//fin si hay espacio en Bloques luego del sort
                    
                    }//fin de si hay bloques disponibles
                
                
                
                    
       
                    }//fin si existe en las logicas    
                    
                }else{//No existe
                    
                    printf("\nInterprete (X)#: _ ERROR_10.5(Fs) Error No Existe Una Particion Extendida \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                    
                }
                
                
            }else{//es una Primaria
                
                if(mbr2.particiones[posPrimaria].formateada!=1){
                    printf("\nInterprete (X)#: _ ERROR_10.5(Mkfile) No Esta Formateada la Particion \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                }else{
                //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",mbr2.particiones[posPrimaria].part_name);
                int Nestructuras=TamaEC(mbr2.particiones[posPrimaria].part_size);//calculando numero d eEstructuras
                
                //------------------quitar comillas
                char env2[1000];
                strcpy(env2,funcion.Contenido);
                quitarComillas(env2);
                printf("El Contenido es= %s \n",sincomillas);
                //--------------------------------
                //----------contar caracteres del archivo-----
                int cont=0;            
                while(sincomillas[cont]!=NULL){
                    cont++;
                }
                printf("El Tamaño del Contenido es= %i \n",cont);
                //-----------------------------------------
                //-----Encontrar numero de bloques a usar--------
                int n=cont;
                int nbloques=0;
                if(n<50){
                    nbloques=1;
                }else{
                
                    do{
                    
                        n=n-50;
                        nbloques++;
                        
                    }while(n>50);
                    nbloques++;
                    
                }
                int nultimo=n;
                int aregloBloques[nbloques];
                char bloqueMemoria[50];
                
                
                
                printf("El Numero de Bloques a Usar por Este Archivo es= %i \n",nbloques);
                //------------------------------------------------
                //-----------Cargar Bitmap a Memoria--------------
                int inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                int finalBitmap=mbr2.particiones[posPrimaria].part_start+(Nestructuras*sizeof(Bitmap));
                Bitmap b;
                int Bit[Nestructuras];
                FILE* file3= fopen(path, "rb+");  
                for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps

                    fseek(file3,inicioBitmap,SEEK_SET);
                    fread(&b, sizeof(Bitmap), 1, file3);
                    printf("Dato del Bitmap [%i] =",i);
                    printf(" '%i'\n",b.bit);
                    Bit[i]=b.bit;
                    inicioBitmap=inicioBitmap+sizeof(Bitmap);

                }
                fclose(file3);
                //busca si hay suficientes 0
                int x=0;
                for(int j=0; j<Nestructuras; j++){
                    if(Bit[j]==0){
                        x++;
                    }
                }
                
                if(x<nbloques){
                    
                printf("\nInterprete #_ ERROR_10.3(Mkfile) NO HAY BLOQUES DISPONIBLES \n\n\n",funcion.id);
                ErrorT++;
                ErrorFormatear++;
                    
                }else{
                    //-----------------------------------------------------------
                    //buscar que tipo d ajuste usa la Particion y setea la posicion del bitmap donde iniciara
                    int posObtenidaDeBitmap=-1;
                    int hayEspacioEnBloques=1;
                    //hacer PRIMER AJUSTE
                    if(mbr2.particiones[posPrimaria].part_fit=='F'||mbr2.particiones[posPrimaria].part_fit=='f'){
                        int NoExisteEspacio=-1;

                        for(int j=0; j<Nestructuras; j++){

                            if(Bit[j]==0){//encontro un espacio
                                //verificar si hay espacio para todos sus nbloques
                                int indiceJ=j+nbloques;
                                for(int i=j; i<indiceJ; i++){//inicia desde la posicion j hasta el nbloques

                                    if(Bit[i]!=0){//si la posicion es diferente de 0 no hay espacio aqui
                                        NoExisteEspacio=1;
                                        i=indiceJ;
                                        hayEspacioEnBloques=0;
                                    }
                                }

                                if(NoExisteEspacio==-1){//significa q si hay espacio

                                    NoExisteEspacio=0;//activa la bandera para darle breake al metodoa
                                }


                            }


                            if(NoExisteEspacio==0){//entonces si hay espacio y
                                posObtenidaDeBitmap=j; //setea la posicion Inicial
                                Bit[j]=1;
                                hayEspacioEnBloques=1;
                                break;
                            }

                        }

                    //Crea el PEORR AJUSTE
                    }else if(mbr2.particiones[posPrimaria].part_fit=='W'||mbr2.particiones[posPrimaria].part_fit=='w'){

                        //encontrar el numero de Fragmentaciones en el disco
                        int contadorFragmentos=0;
                        for(int j=0; j<Nestructuras; j++){
                            if(Bit[j]==0){//encontro un espacio
                                int con=j;
                                while(con<Nestructuras&&Bit[con]!=1){
                                    con++;//aumenta el bloque
                                }
                                j=con;
                                contadorFragmentos++;
                            }
                        }
                        //crear arreglo de fragmentaciones
                        Ajuste Fragmentos[contadorFragmentos+1];
                        //setear los datos de cada fragmentacion
                        contadorFragmentos=0;
                        for(int j=0; j<Nestructuras; j++){
                            if(Bit[j]==0){//encontro un espacio
                                int con=j;
                                int contEspacios=0;
                                while(con<Nestructuras&&Bit[con]!=1){
                                    contEspacios++;//espacios 
                                    con++;//aumenta el bloque
                                }

                                Fragmentos[contadorFragmentos].NbloquesLibres=contEspacios;
                                Fragmentos[contadorFragmentos].posEnBitmap=j;
                                j=con;
                                contadorFragmentos++;
                            }
                        }


                        if(contadorFragmentos<=1){// que no haga sort
                            if(Fragmentos[0].NbloquesLibres<nbloques){//si no hay espacio
                                hayEspacioEnBloques=0;
                            }else{
                            posObtenidaDeBitmap=Fragmentos[0].posEnBitmap;
                            Bit[Fragmentos[0].posEnBitmap]=1;
                            }
                        }else{
                            //buscar la Fragmentacion mas Grande para meter en ese lugar hacemos un sort del Numero de espacios 
                            // en blanco
                            Ajuste Temp;
                            int i;
                            int j;
                            for(i=0; i<contadorFragmentos; i++){
                                for(j=0;j<contadorFragmentos-i;j++){
                                    if(Fragmentos[j].NbloquesLibres<Fragmentos[j+1].NbloquesLibres)
                                    {
                                        Temp=Fragmentos[j]; 
                                        Fragmentos[j]=Fragmentos[j+1]; 
                                        Fragmentos[j+1]=Temp;
                                    }
                                }

                            }
                            //si se ordeno la 0 deveria ser la que tiene la mallor fragmentacion
                            if(Fragmentos[0].NbloquesLibres<nbloques){//si no hay espacio
                                hayEspacioEnBloques=0;
                            }else{
                            posObtenidaDeBitmap=Fragmentos[0].posEnBitmap;
                            Bit[Fragmentos[0].posEnBitmap]=1;
                            }

                        }


                    //CRea el Mejor AJuste    
                    }else if(mbr2.particiones[posPrimaria].part_fit=='B'||mbr2.particiones[posPrimaria].part_fit=='b'){
                        //encontrar el numero de Fragmentaciones en el disco
                        int contadorFragmentos=0;
                        for(int j=0; j<Nestructuras; j++){
                            if(Bit[j]==0){//encontro un espacio
                                int con=j;
                                while(con<Nestructuras&&Bit[con]!=1){
                                    con++;//aumenta el bloque
                                }
                                j=con;
                                contadorFragmentos++;
                            }
                        }
                        //crear arreglo de fragmentaciones
                        Ajuste Fragmentos[contadorFragmentos+1];
                        //setear los datos de cada fragmentacion
                        contadorFragmentos=0;
                        for(int j=0; j<Nestructuras; j++){
                            if(Bit[j]==0){//encontro un espacio
                                int con=j;
                                int contEspacios=0;
                                while(con<Nestructuras&&Bit[con]!=1){
                                    contEspacios++;//espacios 
                                    con++;//aumenta el bloque
                                }

                                Fragmentos[contadorFragmentos].NbloquesLibres=contEspacios;
                                Fragmentos[contadorFragmentos].posEnBitmap=j;
                                j=con;
                                contadorFragmentos++;
                            }
                        }
                        
                        if(contadorFragmentos<=1){// que no haga sort
                            if(Fragmentos[0].NbloquesLibres<nbloques){//si no hay espacio
                                hayEspacioEnBloques=0;
                            }else{
                            posObtenidaDeBitmap=Fragmentos[0].posEnBitmap;
                            Bit[Fragmentos[0].posEnBitmap]=1;
                            }
                        }else{
                            //buscar la Fragmentacion mas Grande para meter en ese lugar hacemos un sort del Numero de espacios 
                            // en blanco
                            Ajuste Temp;
                            int i;
                            int j;
                            for(i=0; i<contadorFragmentos; i++){
                                for(j=0;j<contadorFragmentos-i;j++){
                                    if(Fragmentos[j].NbloquesLibres>Fragmentos[j+1].NbloquesLibres)
                                    {
                                        Temp=Fragmentos[j]; 
                                        Fragmentos[j]=Fragmentos[j+1]; 
                                        Fragmentos[j+1]=Temp;
                                    }
                                }

                            }
                            
                            for(i=0; i<=contadorFragmentos; i++){
                                
                                if(Fragmentos[i].NbloquesLibres<nbloques){
                                    hayEspacioEnBloques=0;
                                }else{
                                    Fragmentos[0]=Fragmentos[i];
                                    hayEspacioEnBloques=1;
                                    contadorFragmentos=contadorFragmentos;
                                    break;
                                }
                                
                            }
                            
                            
                            //si se ordeno la 0 deveria ser la que tiene la mallor fragmentacion
                            if(Fragmentos[0].NbloquesLibres<nbloques){//si no hay espacio
                                hayEspacioEnBloques=0;
                            }else{
                            posObtenidaDeBitmap=Fragmentos[0].posEnBitmap;
                            Bit[Fragmentos[0].posEnBitmap]=1;
                            }

                        }


                    }
                    //fin ajustes

                    if(hayEspacioEnBloques==1){
                        //llenando los 3 bloques de informacion
                        int ind=0;
                        for(int i=0; i<nbloques; i++){//recorre los 3 bloques que va usar

                            //ya encontrada una posicion en los bitmaps
                            //se busca el bloque asociado a la misma
                            int inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                            int finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                            Bloque bloque;  

                            FILE* file4= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){

                                inicioBloques=inicioBloques+sizeof(Bloque);

                            }
                            fseek(file4,inicioBloques,SEEK_SET);
                            fread(&bloque, sizeof(Bloque), 1, file4);
                            fclose(file4);
                            //ya que tenemos el bloque a utilizar seteamos el nombre
                            strcpy(bloque.nombre,funcion.name);


                            if(i==nbloques-1){//es la ultima corrida se arregla el texto
                                for(int i=0; i<nultimo; i++){
                                   bloque.info[i]=sincomillas[ind];
                                   ind++; 
                                }
                            }else{
                                for(int i=0; i<50; i++){
                                    bloque.info[i]=sincomillas[ind];
                                    ind++;
                                }
                            }
                            printf("\nIndice::: %i \n",ind); 
                            //escribe el bloque ya en el disco con sus datos
                            inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                            finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                            FILE* file5= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){
                                inicioBloques=inicioBloques+sizeof(Bloque);
                            }
                            fseek(file5,inicioBloques,SEEK_SET);
                            fwrite(&bloque, sizeof(Bloque), 1, file5);
                            fclose(file5);
                            //esbribe bitmap en el archivo
                            inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                            Bitmap b1;
                            b1.bit=1;
                            FILE* file6= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){//setea 0 en el arreglo de bitmaps
                            inicioBitmap=inicioBitmap+sizeof(Bitmap);
                            }
                            fseek(file6,inicioBitmap,SEEK_SET);
                            fwrite(&b1, sizeof(Bitmap), 1, file6);
                            fclose(file6);
                            posObtenidaDeBitmap++;
                        }



                          //muestra el reporte de los bloques XD
                            Bloque bloquer;
                            int inicioBloques=finalBitmap+1;
                            FILE*file8= fopen(path, "rb+");
                            for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps

                                fseek(file8,inicioBloques,SEEK_SET);
                                fread(&bloquer, sizeof(Bloque), 1, file8);
                                printf("\nNombre Del Bloque: %s \n",bloquer.nombre);
                                printf("Info Del Bloque:   %s \n",bloquer.info);
                                inicioBloques=inicioBloques+sizeof(Bloque);

                            }
                            fclose(file8);
                        }//fin si hay espacio en Bloques luego del sort
                    
                    }//fin de si hay bloques disponibles
                
                }//fin de si esta formateada
                
            }//fin de es primaria 
            
        }//fin de si archivo existe
     
     }//fin de esta montada
     
}

//-------------------------Metodos de Reporte Block --------------------------------

void Reporte_Block(Funcion funcion){

    limpiarvar(caddblock,15000);
    printf("-----------REPORTE BLOCK--------------------\n");
    int estamontada=0;
    int posDeMontada=0;
    int ErrorT=0;
    
     int i;
     for(i=0; i<50; i++){//for para verificar si esta montada la particion a desmontar
         
         if(!strcmp(montadas2[i].id,funcion.id)){      
             printf("Si esta Montada LA Particion...\n");
             posDeMontada=i;
             estamontada=1;
             break;         
         }else{    
         }
         
     }//------------------------------------------------------------------------
     if(estamontada==0){//si la particion no esta montada
     
        printf("\nInterprete #_ ERROR_10.3(GraficarBlock) La particion '%s' No esta Montada \n\n\n",funcion.id);
        ErrorT++;
        ErrorFormatear++;
         
     }else{//si la particion esta montada
        
        char path[100];
        strcpy(path,montadas2[posDeMontada].path3);
        printf("PArticion a Formatear: '%s'\n",montadas2[posDeMontada].id);      
        printf("*La ID::::::::::::::: %s ::::::::::::::::\n",montadas2[posDeMontada].id);
        printf("*La Nombre De Particion****  %s **** \n",montadas2[posDeMontada].name2);
        printf("*La posicion en El Arreglo De Montadas = %i\n",posDeMontada);
        printf("*La Path del DISCO:: %s \n",montadas2[posDeMontada].path3);
        
        FILE* file2= fopen(path, "rb+");
        if (file2==NULL){  //si no existe el archivo
            printf("\nInterprete (X)#: _ ERROR_10.5(GraficarBlock) Error en acceso al Archivo \n\n\n");
            ErrorT++;
            ErrorReporte3++;
        }else{ //si existe el Archivo
            
            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
            fclose(file2);
            
            printf("----------------Particiones En Disco------------------------\n");
            int z=0;
            int activador=0;
            int posPrimaria=-1;
            for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                if(!strcmp(montadas2[posDeMontada].name2,mbr2.particiones[z].part_name))//si encuentra el nombre
                {
                    activador=1;//indica q exite en las primarias
                    posPrimaria=z;//indica la posicion en las primarias
                }   
            }
            
            if(posPrimaria==-1){//es extendida y debe buscar en las logicas y crear en las logicas
                printf("\nDebe Buscar La PArticion en Las Logicas\n");
                
                int existeExtendida=0;
                int posExtendida;
                for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                    if(mbr2.particiones[z].part_type=='E'||mbr2.particiones[z].part_type=='e')//si encuentra Extendida
                    {
                        existeExtendida=1;
                        posExtendida=z;
                    }   
                }
                
                if(existeExtendida==1){//existe la particion Extendida
                    
                    int interruptorLogica=0;
                    int posEnLogicas;
                    int inicio=-1;
                    int tamanoparticion=0;
                    int vacio=1;
                    EBR ebr;
                    int actual=mbr2.particiones[posExtendida].part_start;
                    //printf("posicion actual %i\n",actual);
                    file2= fopen(path, "rb+");
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    int next=ebr.part_next;
                    inicio=sizeof(EBR);

                    int fin=inicio+tamanoparticion;
                    int contador=0;
                    int numeroebr=0;
                    int espaciolibre=mbr2.particiones[posExtendida].part_size;
                    espaciolibre-=32;
                    do{
                    if(ebr.part_next!=-1){
                        actual+=sizeof(EBR);
                        actual+=ebr.part_size;
                        printf("posicion actual %i\n",actual);
                        fseek(file2,actual,SEEK_SET);
                        fread(&ebr, sizeof(EBR), 1, file2);
                        next=ebr.part_next;
                        contador++;
                    }
                    contador++;
                    if(contador==500){
                        break;
                    }
                    }while(next!=-1);

                    printf("-----------------Lista de Particiones------------------------\n");

                    EBR indices[contador+1];
                    contador=0;
                    actual=mbr2.particiones[posExtendida].part_start;
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador], sizeof(EBR), 1, file2);
                    do{

                        if(indices[contador].part_next!=-1){

                            actual+=sizeof(EBR);
                            actual+=indices[contador].part_size;
                            fseek(file2,actual,SEEK_SET);
                            fread(&indices[contador+1], sizeof(EBR), 1, file2);
                            next=indices[contador].part_next;

                        }else{

                            next=-1;
                        }
                        contador++;
                    }while(next!=-1);

                    char a[100];
                    int i=0;
                    for(i=0;i<contador;i++){
                        if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0'
                        vacio=0;

                        if(!strcmp(montadas2[posDeMontada].name2,indices[i].part_name) && indices[i].part_status!='0'){

                            interruptorLogica=1;
                            posEnLogicas=i;
                            
                        }
    
                        }
                        }
                    //FIN DE BUSCAR EN LAS LOGICAS
                    
                    if(interruptorLogica==0){
                        printf("\nInterprete (X)#: _ ERROR_10.5(GraficarBlock) Error No Existe La PArticion Ni En Primarias Ni En Logicas \n\n\n");
                        ErrorT++;
                        ErrorFormatear++;
                    }else{// si existe en las logicas--------------------------------------------------LOGICAS
                    
                        //indices[posEnLogicas].part_start;
                        
                        //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",indices[posEnLogicas].part_name);
                int Nestructuras=TamaEC(indices[posEnLogicas].part_size);
               
                    
                    strcat(caddblock,"digraph g {\n graph [\n rankdir = \"LR\" \n label= \"Reporte Block\";];\n");
                                        //------------------------------------------------
                    //-----------Cargar Bitmap a Memoria--------------
                    int inicioBitmap=indices[posEnLogicas].part_start;
                    int finalBitmap=indices[posEnLogicas].part_start+(Nestructuras*sizeof(Bitmap));
                    Bitmap b;
                    int Bit[Nestructuras];
                    FILE* file3= fopen(path, "rb+");  
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps

                        fseek(file3,inicioBitmap,SEEK_SET);
                        fread(&b, sizeof(Bitmap), 1, file3);
                        Bit[i]=b.bit;
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);

                    }
                    fclose(file3);
                    //-----------------------------------------------------------
                    //-------------PRimero Numero De Bloques A Graficar
                    int contador=0;
                    for(int j=0; j<Nestructuras; j++){//busca una posicion vacia de los bitmaps
                        if(Bit[j]==1){
                            contador++;
                        }
                    }
                    ListaBloques lista[contador];
                    int posObtenidaDeBitmap=-1;
                    int f=0;
                    for(int j=0; j<Nestructuras; j++){//busca una posicion vacia de los bitmaps
                        if(Bit[j]==1){
                            posObtenidaDeBitmap=j;//obtiene la posicion
                            Bloque bloque; 
                            int inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                            int finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                            FILE* file5= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){
                                inicioBloques=inicioBloques+sizeof(Bloque);
                            }
                            fseek(file5,inicioBloques,SEEK_SET);
                            fread(&bloque, sizeof(Bloque), 1, file5);
                            fclose(file5);
                            //Ya Obtenido Grafica Esta Mierda
                            lista[f].b=bloque;
                            lista[f].Pos=posObtenidaDeBitmap;
                            
                            strcat(caddblock,"\"node");
                            char texto[10];
                            sprintf(texto, "%d",posObtenidaDeBitmap);
                            strcat(caddblock,texto);
                            strcat(caddblock,"\" [\n fillcolor=	cadetblue1 \n style=filled \n");
                            strcat(caddblock,"label = \"{{<d0> Bloque ");
                            char texto2[10];
                            sprintf(texto2, "%d",posObtenidaDeBitmap);
                            strcat(caddblock,texto2);
                            strcat(caddblock,"|<d1> ");
                            strcat(caddblock,bloque.nombre);
                            strcat(caddblock,"|<d2> ");
                            strcat(caddblock,bloque.info);
                            strcat(caddblock," }}\" \n");
                            strcat(caddblock,"shape = \"record\" ];\n");
                            f++;
                            }
                    }
                             
                    
                    for(int j=0; j<contador-1; j++){
                    int cc=j;
                    int ccc=j+1;
                    if(!strcmp(lista[cc].b.nombre , lista[ccc].b.nombre)){
                        strcat(caddblock,"\"node");
                        char texto4[10];
                        sprintf(texto4, "%d",lista[cc].Pos);
                        strcat(caddblock,texto4);
                        strcat(caddblock,"\":d2 -> ");
                        strcat(caddblock,"\"node");
                        char texto5[10];
                        sprintf(texto5, "%d",lista[ccc].Pos);
                        strcat(caddblock,texto5);
                        strcat(caddblock,"\":d2 []; ");
                    }
                    
                   }
                    
                    
                    
                    strcat(caddblock,"}");
                    printf("el DOT: \n\n %s",caddblock);
                    switch_mbr==1;
                    ReporteGenerarBlock(funcion);
                

                    
                    
                     
                    }//fin si existe en las logicas    
                    
                }else{//No existe
                    
                    printf("\nInterprete (X)#: _ ERROR_10.5(GenerarBlock) Error No Existe Una Particion Extendida \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                    
                }
                
            }else{// es Particion PRimaria
                
                if(mbr2.particiones[posPrimaria].formateada!=1){
                    printf("\nInterprete (X)#: _ ERROR_10.5(GenerarBlock) No a Sido Formateada No hay Sistema \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                }else{
                //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",mbr2.particiones[posPrimaria].part_name);
                int Nestructuras=TamaEC(mbr2.particiones[posPrimaria].part_size);
                
                
                    strcat(caddblock,"digraph g {\n graph [\n rankdir = \"LR\" \n label= \"Reporte Block\";];\n");
                    
                    //------------------------------------------------
                    //-----------Cargar Bitmap a Memoria--------------
                    int inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                    int finalBitmap=mbr2.particiones[posPrimaria].part_start+(Nestructuras*sizeof(Bitmap));
                    Bitmap b;
                    int Bit[Nestructuras];
                    FILE* file3= fopen(path, "rb+");  
                    for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps

                        fseek(file3,inicioBitmap,SEEK_SET);
                        fread(&b, sizeof(Bitmap), 1, file3);
                        Bit[i]=b.bit;
                        inicioBitmap=inicioBitmap+sizeof(Bitmap);

                    }
                    fclose(file3);
                    //-----------------------------------------------------------
                    //-------------PRimero Numero De Bloques A Graficar
                    int contador=0;
                    for(int j=0; j<Nestructuras; j++){//busca una posicion vacia de los bitmaps
                        if(Bit[j]==1){
                            contador++;
                        }
                    }
                    ListaBloques lista[contador];
                    int posObtenidaDeBitmap=-1;
                    int f=0;
                    for(int j=0; j<Nestructuras; j++){//busca una posicion vacia de los bitmaps
                        if(Bit[j]==1){
                            posObtenidaDeBitmap=j;//obtiene la posicion
                            Bloque bloque; 
                            int inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                            int finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                            FILE* file5= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){
                                inicioBloques=inicioBloques+sizeof(Bloque);
                            }
                            fseek(file5,inicioBloques,SEEK_SET);
                            fread(&bloque, sizeof(Bloque), 1, file5);
                            fclose(file5);
                            //Ya Obtenido Grafica Esta Mierda
                            lista[f].b=bloque;
                            lista[f].Pos=posObtenidaDeBitmap;
                            
                            strcat(caddblock,"\"node");
                            char texto[10];
                            sprintf(texto, "%d",posObtenidaDeBitmap);
                            strcat(caddblock,texto);
                            strcat(caddblock,"\" [\n fillcolor=	cadetblue1 \n style=filled \n");
                            strcat(caddblock,"label = \"{{<d0> Bloque ");
                            char texto2[10];
                            sprintf(texto2, "%d",posObtenidaDeBitmap);
                            strcat(caddblock,texto2);
                            strcat(caddblock,"|<d1> ");
                            strcat(caddblock,bloque.nombre);
                            strcat(caddblock,"|<d2> ");
                            strcat(caddblock,bloque.info);
                            strcat(caddblock," }}\" \n");
                            strcat(caddblock,"shape = \"record\" ];\n");
                            f++;
                            }
                    }
                             
                    
                    for(int j=0; j<contador-1; j++){
                    int cc=j;
                    int ccc=j+1;
                    if(!strcmp(lista[cc].b.nombre , lista[ccc].b.nombre)){
                        strcat(caddblock,"\"node");
                        char texto4[10];
                        sprintf(texto4, "%d",lista[cc].Pos);
                        strcat(caddblock,texto4);
                        strcat(caddblock,"\":d2 -> ");
                        strcat(caddblock,"\"node");
                        char texto5[10];
                        sprintf(texto5, "%d",lista[ccc].Pos);
                        strcat(caddblock,texto5);
                        strcat(caddblock,"\":d2 []; ");
                    }
                    
                   }
                    
                    
                    
                    strcat(caddblock,"}");
                    printf("el DOT: \n\n %s",caddblock);
                    switch_mbr==1;
                    ReporteGenerarBlock(funcion);
                    
                
                }//fin si es formateada o no 
                
            }//fin de es primaria o logica
            
        }//fin existencia de Archivo
     
     }//fin si esta montada

     
    
}

void ReporteGenerarBlock(Funcion funcion){
    int ErrorT=0;
    
    /******************* Quita "comillas" en la path **************************/
    char pathauxiliar[500];
    strcpy(pathauxiliar,funcion.path);
    
    char finalizado[500];
    strcpy(finalizado,"cd /\n");
    if(pathauxiliar[0]=='\"')
    {
        limpiarvar(funcion.path,100);
        int q=1;
        while(pathauxiliar[q]!='\"')
        {
            char c2[1];
            c2[0]=pathauxiliar[q];
            strncat(funcion.path,c2,1);
            q++;
        }

    }
    //**************************************************************************
    
    
    //**************************************************************************
    //*******Para crear Carpetas en los Directorios si no an sido Creadas*******
    
    int indice=0;
    char carpeta2[500];
    while(funcion.path[indice]!='.')
    {
    if(funcion.path[indice]!='/')
        {
            //carpeta=ConcatenarCadenaCaracter(carpeta,pathoriginal[indice]);
            char c1[1];
            c1[0]=funcion.path[indice];
            strncat(carpeta2,c1,1);
        }
        else
        {
            
            strcat(finalizado,"mkdir ");
            strcat(finalizado,"\"");
            strcat(finalizado,carpeta2);
            strcat(finalizado,"\"");
            strcat(finalizado,"\n");
            strcat(finalizado,"cd ");
            strcat(finalizado,"\"");
            strcat(finalizado,carpeta2);
            strcat(finalizado,"\"");
            strcat(finalizado,"\n");
            strcat(carpeta2,"");
            limpiarvar(carpeta2,500);
            
        }
        indice++;
    }
    
    printf("\nImprimir el comando q ejecuta en la terminal si el directorio no existe: %s\n",finalizado);
    
    system(finalizado);
    
    //**************************************************************************

    
    //**************************************************************************
    
    char consola[200]=" ";
    FILE *flujo=fopen("/home/carlos/Escritorio/Reporte_block.dot","w");
    if (flujo==NULL){
        
        printf("\nInterprete (X)#: _ ERROR_7.2 Error Al Crear el ARchivo \n\n \n");
        ErrorT++;
        ErrorReporte2++;
    
    }else{
    
            
        strcat(consola,"dot -Tpdf /home/carlos/Escritorio/Reporte_block.dot -o");
        strcat(consola,funcion.path);
            
        fputs(caddblock,flujo);//escribe..
        switch_mbr=0;//apaga el switch
        fclose(flujo);
        //system("dot -Tpdf /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_mbr.dot -o /home/carlos/NetBeansProjects/Practica_Archivos1.3/Reportes/Reporte_mbr.pdf");
        system(consola);
        ContadorComandosExitosos++;

       

    }
     
}

//-------------------------Metodos ELiminar Bloques  --------------------------------

void EliminarArchivo(Funcion funcion){
    printf("-----------Crear ARchivo--------------------\n");
    int estamontada=0;
    int posDeMontada=0;
    int ErrorT=0;
    
     int i;
     for(i=0; i<50; i++){//for para verificar si esta montada la particion a desmontar
         
         if(!strcmp(montadas2[i].id,funcion.id)){      
             printf("Si esta Montada LA Particion...\n");
             posDeMontada=i;
             estamontada=1;
             break;         
         }else{    
         }
         
     }//------------------------------------------------------------------------
      if(estamontada==0){//si la particion no esta montada
     
        printf("\nInterprete #_ ERROR_10.3(eliminar Arch) La particion '%s' No esta Montada \n\n\n",funcion.id);
        ErrorT++;
        ErrorFormatear++;
         
     }else{//si la particion esta montada
        
        char path[100];
        strcpy(path,montadas2[posDeMontada].path3);
        printf("PArticion a Eliminar: '%s'\n",montadas2[posDeMontada].id);      
        printf("*La ID::::::::::::::: %s ::::::::::::::::\n",montadas2[posDeMontada].id);
        printf("*La Nombre De Particion****  %s **** \n",montadas2[posDeMontada].name2);
        printf("*La posicion en El Arreglo De Montadas = %i\n",posDeMontada);
        printf("*La Path del DISCO:: %s \n",montadas2[posDeMontada].path3);
        
        FILE* file2= fopen(path, "rb+");
        if (file2==NULL){  //si no existe el archivo
            printf("\nInterprete (X)#: _ ERROR_10.5(Eliminar arch) Error en acceso al Archivo \n\n\n");
            ErrorT++;
            ErrorReporte3++;
        }else{ //si existe el Archivo
            
            MbrDisco mbr2;
            fseek(file2,0,SEEK_SET);
            fread(&mbr2, sizeof(MbrDisco), 1, file2);
            fclose(file2);
            
            printf("----------------Particiones En Disco------------------------\n");
            int z=0;
            int activador=0;
            int posPrimaria=-1;
            for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                if(!strcmp(montadas2[posDeMontada].name2,mbr2.particiones[z].part_name))//si encuentra el nombre
                {
                    activador=1;//indica q exite en las primarias
                    posPrimaria=z;//indica la posicion en las primarias
                }   
            }
            
            if(posPrimaria==-1){//es extendida y debe buscar en las logicas y crear en las logicas
                printf("\nDebe Buscar La PArticion en Las Logicas\n");
                
                int existeExtendida=0;
                int posExtendida;
                for(z=0;z<4;z++){ //recorre el arreglo de particiones primarias
                    if(mbr2.particiones[z].part_type=='E'||mbr2.particiones[z].part_type=='e')//si encuentra Extendida
                    {
                        existeExtendida=1;
                        posExtendida=z;
                    }   
                }
                
                if(existeExtendida==1){//existe la particion Extendida
                    
                    int interruptorLogica=0;
                    int posEnLogicas;
                    int inicio=-1;
                    int tamanoparticion=0;
                    int vacio=1;
                    EBR ebr;
                    int actual=mbr2.particiones[posExtendida].part_start;
                    //printf("posicion actual %i\n",actual);
                    file2= fopen(path, "rb+");
                    fseek(file2,actual,SEEK_SET);
                    fread(&ebr, sizeof(EBR), 1, file2);
                    int next=ebr.part_next;
                    inicio=sizeof(EBR);

                    int fin=inicio+tamanoparticion;
                    int contador=0;
                    int numeroebr=0;
                    int espaciolibre=mbr2.particiones[posExtendida].part_size;
                    espaciolibre-=32;
                    do{
                    if(ebr.part_next!=-1){
                        actual+=sizeof(EBR);
                        actual+=ebr.part_size;
                        printf("posicion actual %i\n",actual);
                        fseek(file2,actual,SEEK_SET);
                        fread(&ebr, sizeof(EBR), 1, file2);
                        next=ebr.part_next;
                        contador++;
                    }
                    contador++;
                    if(contador==500){
                        break;
                    }
                    }while(next!=-1);

                    printf("-----------------Lista de Particiones------------------------\n");

                    EBR indices[contador+1];
                    contador=0;
                    actual=mbr2.particiones[posExtendida].part_start;
                    fseek(file2,actual,SEEK_SET);
                    fread(&indices[contador], sizeof(EBR), 1, file2);
                    do{

                        if(indices[contador].part_next!=-1){

                            actual+=sizeof(EBR);
                            actual+=indices[contador].part_size;
                            fseek(file2,actual,SEEK_SET);
                            fread(&indices[contador+1], sizeof(EBR), 1, file2);
                            next=indices[contador].part_next;

                        }else{

                            next=-1;
                        }
                        contador++;
                    }while(next!=-1);

                    char a[100];
                    int i=0;
                    for(i=0;i<contador;i++){
                        if(indices[i].part_start!=-1 ){//&& indices[i].part_status!='0'
                        vacio=0;

                        if(!strcmp(montadas2[posDeMontada].name2,indices[i].part_name) && indices[i].part_status!='0'){

                            interruptorLogica=1;
                            posEnLogicas=i;
                            
                        }
    
                        }
                        }
                    //FIN DE BUSCAR EN LAS LOGICAS
                    
                    if(interruptorLogica==0){
                        printf("\nInterprete (X)#: _ ERROR_10.5(Eliminar arch) Error No Existe La PArticion Ni En Primarias Ni En Logicas \n\n\n");
                        ErrorT++;
                        ErrorFormatear++;
                    }else{// si existe en las logicas--------------------------------------------------LOGICAS
                    
                        //indices[posEnLogicas].part_start;
                        
                        //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",indices[posEnLogicas].part_name);
                int Nestructuras=TamaEC(indices[posEnLogicas].part_size);

                
                
                
                
                
                
                    
                    
                     
                    }//fin si existe en las logicas    
                    
                }else{//No existe
                    
                    printf("\nInterprete (X)#: _ ERROR_10.5(Eliminar arch) Error No Existe Una Particion Extendida \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                    
                }
                
            }else{// es Particion PRimaria
                
                if(mbr2.particiones[posPrimaria].formateada!=1){
                    printf("\nInterprete (X)#: _ ERROR_10.5(Eliminar arch) No a Sido Formateada No hay Sistema \n\n\n");
                    ErrorT++;
                    ErrorFormatear++;
                }else{
                //*******calculando Informacion
                printf("***La Particion donde SE Creara TODO:: '%s' \n",mbr2.particiones[posPrimaria].part_name);
                int Nestructuras=TamaEC(mbr2.particiones[posPrimaria].part_size);
                                int Elimino=0;
                            //------------------------------------------------
                            //-----------Cargar Bitmap a Memoria--------------
                            int inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                            int finalBitmap=mbr2.particiones[posPrimaria].part_start+(Nestructuras*sizeof(Bitmap));
                            Bitmap b;
                            int Bit[Nestructuras];
                            FILE* file3= fopen(path, "rb+");  
                            for(int i=0; i<Nestructuras; i++){//setea 0 en el arreglo de bitmaps

                                fseek(file3,inicioBitmap,SEEK_SET);
                                fread(&b, sizeof(Bitmap), 1, file3);
                                Bit[i]=b.bit;
                                inicioBitmap=inicioBitmap+sizeof(Bitmap);

                            }
                            fclose(file3);
                            //-----------------------------------------------------------
                            //-------------PRimero Numero De Bloques A Graficar
                            int contador=0;
                            for(int j=0; j<Nestructuras; j++){//busca una posicion vacia de los bitmaps
                                if(Bit[j]==1){
                                    contador++;
                                }
                            }
                            
                    ListaBloques lista[contador];
                    int posObtenidaDeBitmap=-1;
                    int f=0;
                    for(int j=0; j<Nestructuras; j++){//busca una posicion vacia de los bitmaps
                        if(Bit[j]==1){
                            posObtenidaDeBitmap=j;//obtiene la posicion
                            Bloque bloque; 
                            int inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                            int finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                            FILE* file5= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){
                                inicioBloques=inicioBloques+sizeof(Bloque);
                            }
                            fseek(file5,inicioBloques,SEEK_SET);
                            fread(&bloque, sizeof(Bloque), 1, file5);
                            fclose(file5);
                            //Ya Obtenido Grafica Esta Mierda
                            
                            if(!strcmp(bloque.nombre,funcion.fileid)){//si el nombre es el mismo que el bloque q cargo
                            //debe elimiar el bloque y poner su poss en 0 del bitmap
                                printf("\nEliminando bloque: %s\n\n",bloque.nombre);
                                printf("\nEliminando Info: %s\n\n",bloque.info);
                                
                                strcpy(bloque.nombre,"vacio");
                                strcpy(bloque.info,"vacio");
                                
                                Elimino=1;
                                
                            //escribe el bloque ya en el disco con sus datos
                            inicioBloques=finalBitmap+1;//el inicio de los bloques es el final del bitmap + 1
                            finalBloques=inicioBloques+(Nestructuras*sizeof(Bloque));
                            FILE* file5= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){
                                inicioBloques=inicioBloques+sizeof(Bloque);
                            }
                            fseek(file5,inicioBloques,SEEK_SET);
                            fwrite(&bloque, sizeof(Bloque), 1, file5);
                            fclose(file5);
                            //esbribe bitmap en el archivo
                            inicioBitmap=mbr2.particiones[posPrimaria].part_start;
                            Bitmap b1;
                            b1.bit=0;
                            FILE* file6= fopen(path, "rb+");
                            for(int i=0; i<posObtenidaDeBitmap; i++){//setea 0 en el arreglo de bitmaps
                            inicioBitmap=inicioBitmap+sizeof(Bitmap);
                            }
                            fseek(file6,inicioBitmap,SEEK_SET);
                            fwrite(&b1, sizeof(Bitmap), 1, file6);
                            fclose(file6);
                                
                            }else{
                                printf("bloque no igual\n");
                            }

                        }
                    }
                    
  
                    if(Elimino==0){
                    printf("\nInterprete (X)#: _ ERROR_(Eliminar arch) No Pudo Eliminar: '%s' \n\n\n",funcion.fileid);
                    ErrorT++;
                    ErrorFormatear++;
                    }else{
                        printf("\nELIMINACION DE BLOQUE '%s' FINALIZADA      ^___^ \n",funcion.fileid);
                    }
                
                   
                
                
                    
                
                }//fin si es formateada o no 
                
            }//fin de es primaria o logica
            
        }//fin existencia de Archivo
     
     }//fin si esta montada

}

// Simbolos::: > 

// #comentario :D 

// exec &path->"/home/carlos/Escritorio/Practica1/Practica1Archivos/Entrada.h"

//  Mkdisk &size->17 &path->"/home/mis discos/" &NaMe->Disco4.dsk

//  fdisk %delete->full &name->"ParticionL2" &path->"/home/carlos/Escritorio/Practica1/Test/Discos1/Disco1.dsk" 


//   lspart &path->"/home/carlos/Escritorio/Practica1/Test/Discos2/Disco_3.dsk"

//