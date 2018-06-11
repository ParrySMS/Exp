#include<stdio.h>
#include<string.h>

void echoMenu(void);
void gradeCount(void);
void matrixAdd(int ma[][5],int mb[][5],int mc[][5],int len);
void echoMatrix(int ma[][5],int mb[][5],int mc[][5],int len);
void yanghuiTri(int n);
void login();
void fillMatrix(int matrix[][5],int len,int params);

int main() {
	char c;
	int ma[5][5],mb[5][5],mc[5][5];

	echoMenu();
	while( (c = getchar())!='0') {

		switch(c) {
			case '1':
				gradeCount();
				echoMenu();
				break;
			case '2':
				fillMatrix(ma,5,1);
				fillMatrix(mb,5,1);
				matrixAdd(ma,mb,mc,5);
				echoMatrix(ma,mb,mc,5);
				echoMenu();
				break;
			case '3':
				yanghuiTri(10);
				echoMenu();
				break;
			case '4':
				login();
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

	printf("* 1. 成绩统计");
	for(i=0; i<(14+20-5-4*2-1); i++) {
		printf(" ");
	}
	printf("*\n");

	printf("* 2. 矩阵相加");
	for(i=0; i<(14+20-5-4*2-1); i++) {
		printf(" ");
	}
	printf("*\n");

	printf("* 3. 杨辉三角");
	for(i=0; i<(14+20-5-4*2-1); i++) {
		printf(" ");
	}
	printf("*\n");

	printf("* 4. 用户登陆");
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

void 	gradeCount() {
	int g[20];
	int i,j,k,sum,numHigh,numLow;
	double avg;

	//input
	printf("input 10 grade numbers(eg.2 3 4 ...):\n");
	for(i=0; i<10; i++) {
		scanf(" %d",&g[i]);
	}

	//sort
	for(i=0; i<10-1; i++) {
		for(j=i+1; j<10; j++) {
			if(g[i]<g[j]) {
				//swap0
				g[i]=g[i]+g[j];

				g[j]=g[i]-g[j];
				g[i]=g[i]-g[j];
			}
		}
	}
	printf("\n");
	printf("Grade: ");
	for(i=0; i<10; i++) {
		printf("%d ",g[i]);
	}
	printf("\n");



	//avg
	for(sum =0,i=0; i<10; i++) {
		sum=sum+g[i];
	}
	avg = (double)sum/10.0;
	printf("Avg: %.2lf \n",avg);

	//count
	numHigh = 0;
	numLow = 0;
	for(i=0; i<10; i++) {
		if(g[i]>avg) {
			numHigh++;
		} else {
			numLow++;
		}
	}
	printf("Higher than average point: %d \n",numHigh);
	printf("Lower than average point: %d \n",numLow);

}

//fill the matrix with some params
void fillMatrix(int matrix[][5], int len, int params) {
	int i,j;
	for(i=0; i<len; i++) {
		for(j=0; j<len; j++) {
			matrix[i][j]=params+i-1;
		}
	}

}


void matrixAdd(int ma[][5],int mb[][5],int mc[][5],int len) {
	int i,j;

	for(i=0; i<len; i++) {
		for(j=0; j<len; j++) {
			mc[i][j] = ma[i][j] + mb[i][j];
		}
	}


}

void echoMatrix(int ma[][5],int mb[][5],int mc[][5],int len) {
	int i,j;

	printf("\n");
	printf("\n");
	//ma
	for(i=0; i<len; i++) {
		printf("{");
		for(j=0; j<len; j++) {
			printf(" %d",ma[i][j]);
		}
		printf(" }\n");
	}
	printf("\n");
	printf("\n");

	printf("     +     \n");
	printf("   +++++  \n");
	printf("     +     \n");

	printf("\n");
	printf("\n");

	//mb
	for(i=0; i<len; i++) {
		printf("{");
		for(j=0; j<len; j++) {
			printf(" %d",mb[i][j]);
		}
		printf(" }\n");
	}
	printf("\n");
	printf("\n");

	//mc
	for(i=0; i<len; i++) {
		//mid
		if(i==len/2) {
			printf("     =     ");
		} else {
			printf("           ");
		}

		printf("{");
		for(j=0; j<len; j++) {
			printf(" %d",mc[i][j]);
		}
		printf(" }\n");
	}
	printf("\n");
	printf("\n");


}

void yanghuiTri(int n) {

	int i,j,a[20][20]= {0};

	//fri-col --> 1
	for(i=0; i<n; i++) {
		a[i][0]=1;
	}

	//other num --> left top + right top
	for(i=1; i<n; i++) {
		for(j=1; j<=i; j++) {
			a[i][j] = a[i-1][j-1] + a[i-1][j];
		}
	}

	//echo
	printf("\n");
	for(i=0; i<n; i++) {
		for(j=0; j<=i; j++) {
			printf(" %d ",a[i][j]);
		}
		printf("\n");
	}
}


void login() {
	int i,j;
	char pw1[20]= {0};
	char pw2[20]= {0};
	char stuNum[]="2018008008";
	char c;

	printf("\n");
	printf("Please fill your password (1-20 bit):");
	c=getchar();
	i=0;
	while((c=getchar())!='\n') {
		if(i>=19) {
			printf("passward invalid...\n");
			return;
		} else {
			pw1[i]=c;
			i++;
		}
	}
	printf("\n");
	printf("Please repeat your password again (1-20 bit):");
	i=0;
	while((c=getchar())!='\n') {
		if(i>=19) {
			printf("passward invalid...\n");
			return;
		} else {
			pw2[i]=c;
			i++;
		}
	}

	//check
	if(strcmp(pw1,pw2)==0) {
		printf("\n");
		printf("password:%s\n",pw1);
		printf("\n");
		printf("stuNum:%s\n",stuNum);
	} else {
		printf("\n");
		printf("Login failed\n");

	}
	printf("\n");





}



