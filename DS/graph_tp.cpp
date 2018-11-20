#include <iostream>

using namespace std;

const int MAX = 9999;

int main() {
	int i,j,k,n,t,deg=0,v=-1;
	int** mx;
	int* visit;
	cin>>t;
	while(t--) {
		cin>>n;
		mx = new int*[n];
		visit = new int[n]();

		//init
		for(i=0; i<n; i++) {
			mx[i] = new int[n]();
			visit[i] = 0;
			for(j=0; j<n; j++) {
				cin>>mx[i][j];
			}
		}


		for(k=0; k<n; k++) {
			// 拓扑排序算法：给出有向图邻接矩阵
			//1.逐列扫描矩阵，找出入度为0且编号最小的顶点v
			for(i=0,v = MAX; i<n; i++) {
				deg = 0;

				if(visit[i] == 1) {
					continue;
				}

				for(j=0; j<n; j++) {
					deg += mx[j][i];
				}

				if(deg == 0) {
					v = i<v?i:v;
				}
			}

			//	2.输出v，并标识v已访问
			if(v == MAX) {
//				cout<<"break ";
				break; //not found end
			}

			cout<<v<<" ";
			visit[v] = 1;

			//	3.把矩阵第v行全清0
			for(j=0; j<n; j++) {
				mx[v][j] = 0;
			}
			//	重复上述步骤，直到所有顶点输出为止
		}//for k

		cout<<endl;

	}//while

	int p;
	for(i=0; i<n; i++) {
		delete []  mx[i];
	}
	delete [] mx;
	delete [] visit;

	return 0;
}

