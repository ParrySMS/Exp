#include <iostream>
#include <string>
using namespace std;

class BinTreeNode {
	public:
		char data;
		BinTreeNode *left;
		BinTreeNode *right;
		BinTreeNode () {
			left = NULL;
			right = NULL;
		}
		~BinTreeNode();
};


class BinTree {
	private:
		BinTreeNode* root;
		int pos;

		int len ;
		void CreateBinTree();
		void InOrder(BinTreeNode *t);
	public:
		int *treeAr;
		BinTree() {};
		~BinTree() {};
		void CreateTree();
		void InOrder();//ÖÐÐò

};


//public ÖÐÐò
void BinTree::InOrder() {
	InOrder(root);
	cout<<endl;
}

//private ÖÐÐò
void BinTree::InOrder(BinTreeNode *t) {

	if(t!=NULL) {
		InOrder(t->left);
		cout<<t->data<<" ";
		InOrder(t->right);
	}
}


void BinTree::CreateTree() {
	pos = 0;
	len = sizeof(treeAr);
	root = NULL;
	CreateBinTree();
}

void BinTree::CreateBinTree() {
	int i,data;
	BinTreeNode* t;

	data = treeAr[0];
	if(root==NULL) {
		cout<<"new root,data ="<<data<<endl;
		root = new BinTreeNode();
		root->data = data;
	}

	for(i=1; i<len; i++) {
		t = root;
		data = treeAr[i];
		cout<<"while--i:"<<i<<endl;
		while(1) {
			cout<<"root:"<<root<<endl;
			cout<<"t:"<<t<<endl;

			if(t==NULL) {
				
				//todo need to linked to upper
				
				t = new BinTreeNode();
				t->data = data;
				cout<<"t:"<<t<<endl;
				cout<<"new t,data ="<<data<<endl;
				break;

			}

			if(data == t->data) {
				cout<<"same data"<<endl;
				break;
			}

			if(data>t->data) {
				t=t->right;
				cout<<"t->right"<<endl;
				cout<<"t:"<<t<<endl;
			} else {
				t=t->left;
				cout<<"t->left"<<endl;
				cout<<"t:"<<t<<endl;
			}
		}

	}

}


int main() {
	BinTree * bin;
	int i,j,t,n,m;
	cin>>t;
	while(t--) {
		bin = new BinTree();
		cin>>n;
		bin->treeAr = new int[n]();
		for(i = 0; i<n; i++) {
			cin>>bin->treeAr[i];
		}
		//bulid tree
		bin->CreateTree();
		bin->InOrder();
	}

	delete [] bin;
	return 0;
}

