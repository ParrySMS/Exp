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
			// ���������㷨����������ͼ�ڽӾ���
			//1.����ɨ������ҳ����Ϊ0�ұ����С�Ķ���v
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

			//	2.���v������ʶv�ѷ���
			if(v == MAX) {
//				cout<<"break ";
				break; //not found end
			}

			cout<<v<<" ";
			visit[v] = 1;

			//	3.�Ѿ����v��ȫ��0
			for(j=0; j<n; j++) {
				mx[v][j] = 0;
			}
			//	�ظ��������裬ֱ�����ж������Ϊֹ
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

