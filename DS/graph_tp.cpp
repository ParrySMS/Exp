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

		/**TODO ���������㷨����������ͼ�ڽӾ���
		1.����ɨ������ҳ����Ϊ0�ұ����С�Ķ���v

		2.���v������ʶv�ѷ���

		3.�Ѿ����v��ȫ��0

		�ظ��������裬ֱ�����ж������Ϊֹ

		**/

	}

	return 0;
}

