#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

int main() {
    int * p=NULL;
    int i; 
	p=(int *)malloc(256*1024*1024);
	memset(p,0,sizeof(p));
	
	for	(i=0;i<3*4;i=i+4){
		printf("M--pid=%d\n",getpid());
		printf("value:p[%d]-->%d",i,*(p+i));
		getchar();
	}
	free(p); 
	return 0;
}
