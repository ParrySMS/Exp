#include <stdio.h>
#include <stdlib.h>
#include <string.h>
 
 int main() {

     int * p=NULL;
     p=(int *)malloc(sizeof(int));
     if(NULL==p){
         printf("Can't get memory!\n");
         return -1;
     }

     printf("%d\n",*p);           //�������Ŀռ��ϵ�ֵ
     printf("%d\n",p); 
    // memset(p,0,sizeof(int));     //��pָ��Ŀռ���0
    // printf("%d\n",*p);           //�������memset������Ľ��
	free(p);
	p=NULL;
    // *p=2;
      printf("free\n");
    printf("%d\n",*p);
    printf("%d\n",p); 
     return 0;
}
