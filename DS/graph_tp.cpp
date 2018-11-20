#include <iostream>

using std;

const int MaxLen = 20;
const int MaxDist = 9999;

int main() {
	int i,j,n,t;
	int* mx;
	cin>>t;
	while(t--) {
		cin>>n;
		mx = new int[n]();

		for(i=0; i<n; i++) {
			for(j=0; j<n; i++) {

				cin>>mx[i][j];
			}
		}

		/**TODO 拓扑排序算法：给出有向图邻接矩阵
		1.逐列扫描矩阵，找出入度为0且编号最小的顶点v

		2.输出v，并标识v已访问

		3.把矩阵第v行全清0

		重复上述步骤，直到所有顶点输出为止

		**/

	}

	return 0;
}

