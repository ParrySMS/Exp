#include <iostream>
#include <queue>
#include <ctime>
#include <stdio.h>
#include <stdlib.h>

#define MAX 1000
#define MAX_N 500

using namespace std;
const int mx_c[MAX][MAX];//�������� ���ڽӾ���
const int mx_f[MAX][MAX];//���������

void getRandMap(int mx_c[][MAX],int n,int e) ;//����һ�������ͼ

/*��������[a,b]�ϵ������*/
inline int getRand(int a ,int b) {
	return (int) ( ((double)rand()/RAND_MAX)*(b-a) + a);
};

void getRandMap(int mx[][MAX],int n,int e) {
	int n1,n2;
	
	srand((int)geypid());

	for(i=0; i<e; i++) {
		n1 = getRand(0,n-1);
		n2 = getRand(0,n-1);
		mx[n1][n2] = getRand(0,50);
	}
}

int main() {
	int node_num,edge_num;
	
//	cin>>node_num>>edge_num; 
//	getRandMap(mx_c,node_num,edge_num);

	return 0;
}
