#include <stdio.h>
#include <stdlib.h>

void echoMenu();
void insert(int a[]);
void init(int a[]);

int main() {
	char c;
	int a[11];
	//meau
	echoMenu();

	while( (c = getchar())!='0') {
		switch(c) {
			case '1':
				//fill
				init(a);
				insert(a);
				echoMenu();
				break;
			case '2':
				printf("\ndeveloping....\n");
				echoMenu();
				break;
			case '3':
				printf("\ndeveloping....\n");
				echoMenu();
				break;
		}
	}
	return 0;
}


void echoMenu() {

	int i,j,k;
	printf("\n");
	for(i=0; i<10; i++) {
		printf("*");
	}

	printf(" Menu section ");

	for(i=0; i<10; i++) {
		printf("*");
	}

	printf("\n");

	printf("* 1. 插入操作");
	for(i=0; i<(14+20-5-4*2-1); i++) {
		printf(" ");
	}
	printf("*\n");

	printf("* 2. 删除操作");
	for(i=0; i<(14+20-5-4*2-1); i++) {
		printf(" ");
	}
	printf("*\n");

	printf("* 3. 查找操作");
	for(i=0; i<(14+20-5-4*2-1); i++) {
		printf(" ");
	}
	printf("*\n");

	printf("* 0. Exit");
	for(i=0; i<(14+20-5-4-1); i++) {
		printf(" ");
	}
	printf("*\n");

	for(i=0; i<(14+20); i++) {
		printf("*");
	}
	printf("\n");
}

void insert(int a[]) {
	int i,j,num,temp;

	//orgin
	printf("\nLisp: ");
	for(i=0; i<10; i++) {
		printf("%d ",a[i]);
	}
	printf("\n");
	printf("\n");

	printf("Please input your num:");
	scanf("%d",&num);

	//insert
	a[10]=num;
	for(i=0; i<11-1; i++) {
		for(j=i+1; j<11; j++) {
			if(a[i]>a[j]) {
				//swap
				a[i]=a[i]+a[j];

				a[j]=a[i]-a[j];
				a[i]=a[i]-a[j];
			}
		}
	}

	//new
	printf("\nNew lisp: ");
	for(i=0; i<11; i++) {
		printf("%d ",a[i]);
	}
	printf("\n");
	printf("\n");


}


void init(int a[]) {
	int i,j;
	//create
	for(i=0; i<10; i++) {
		a[i]=rand()%101;
		//printf("%d\n",a[i]);
	}
	//sort
	for(i=0; i<10-1; i++) {
		for(j=i+1; j<10; j++) {
			if(a[i]>a[j]) {
				//swap
				a[i]=a[i]+a[j];

				a[j]=a[i]-a[j];
				a[i]=a[i]-a[j];
			}
		}
	}
}













