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

     printf("%d\n",*p);           //输出分配的空间上的值
     printf("%d\n",p); 
    // memset(p,0,sizeof(int));     //将p指向的空间清0
    // printf("%d\n",*p);           //输出调用memset函数后的结果
	free(p);
	p=NULL;
    // *p=2;
      printf("free\n");
    printf("%d\n",*p);
    printf("%d\n",p); 
     return 0;
}
