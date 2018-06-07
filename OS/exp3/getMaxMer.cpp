#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

int main() {
	int i,j;
	int size=512*1024*1024;
	double sizeMB;
	int step=100*1024*1024;
	int * p=NULL;

	for(j=0; step>1; step=step/2,j++) {
		p=(int *)malloc(size);

		for(i=0; NULL!=p; i++) {
			free(p);
			// 增加大小
			size = size + step;
			p=(int *)malloc(size);
		}
		//max step back
		//printf("for i %d times\n",i);
		size = size - step;
	}
	if(NULL!=p) {
		free(p);
	}
	sizeMB = (double)size/1024.0/1024.0;
	printf("M--pid=%d\n",getpid());
	printf("total:%.3lf MB-->%d KB \n",sizeMB,size);
	
	return 0; 

}
