#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

int main() {

	int * point[10];
	int i;
	printf("get memory!!---\n");
	printf("M--pid=%d\n",getpid());
	getchar();
	for(i=1; i<=6; i++) {

		int * p=NULL;
		p=(int *)malloc(128/4*1024*1024);
		point[i]=p;

		if(NULL==p) {
			printf("M[%d]--Can't get memory!\n",i);
			return -1;
		}

		printf("M[%d]--pid=%d\n",i,getpid());           //输出分配的空间上的值
		printf("M[%d]--p=%d\n",i,p);
		memset(p,0,sizeof(p));
		// printf("%d\n",*p);           //输出调用memset函数后的结果
	}

	for(i=1; i<=6; i++) {
		if(i==2||i==3||i==5) {
			printf("M[%d]--ready to free\n",i);
			getchar();
			free(point[i]);
			printf("M[%d]-- free!!\n",i);
		} else {
			printf("M[%d]--not free now\n",i);
		}
	}

	//p7 big
	printf("M[7]--ready get 1024/4=256M \n",i);
	getchar();
	int* p = NULL;
	p=(int *)malloc(1024/4*1024*1024);

	if(NULL==p) {
		printf("M[7]--Can't get memory!\n");
		free(point[1]);
		free(point[4]);
		free(point[6]);
		free(point[7]);
		printf("M[1/4/6/7]-- free!!!!\n");
		return -1;
	} else {
		printf("M[7]-- get 1024/4 = 256 memory\n -p=%d\n",p);
	}
	point[7]=p;
	memset(p,0,sizeof(p));

	printf("M[8]--ready get small 128/4 =32M \n",i);
	getchar();


	p=(int *)malloc(128/4*1024*1024);
	if(NULL==p) {
		printf("M[8]--Can't get memory!\n");
	} else {
		printf("M[8]-- get 32M memory\n -p=%d\n",p);
	}
	point[8]=p;
	memset(p,0,sizeof(p));
	
	printf("M[1/4/6/7]--ready to free\n");
	getchar();
	free(point[1]);
	free(point[4]);
	free(point[6]);
	free(point[7]);
	printf("M[1/4/6/7]-- free!!!!\n");
	
	printf("M[8]-- ready free\n");
	getchar();
	
	free(point[8]);
	printf("M[8]-- free!!!!\n");
	getchar();

	return 0;

}
