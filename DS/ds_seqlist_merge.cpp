#include <stdio.h>
#define SIZE 1000
int main() {
	int num,i,j,data,size = 0;
	int ar[SIZE];
	int second[SIZE];

	scanf("%d",&num);
	for(i=0; i<num; i++) {
		scanf(" %d",&ar[i]);
	}
	size = size+num;

	scanf("%d",&num);
	for(j=0; j<num; i++,j++) {
		scanf(" %d",&ar[i]);
	}
	size = size+num;

	//sort
	for(i=0; i<size; i++) {
		for(j=i+1; j<size; j++) {
			if(ar[i]>ar[j]) {
				ar[i] = ar[i] + ar[j];
				ar[j] = ar[i] - ar[j];
				ar[i] = ar[i] - ar[j];
			}
		}
	}


	printf("%d ",size);
	for(i=0; i<size; i++) {
		printf("%d ",ar[i]);
	}


	return 0;
}
