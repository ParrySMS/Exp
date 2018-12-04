#include <iostream>
#include <string>
using namespace std;

class BinTreeNode {
	public:
		int data;
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
		void CreateTree(int len);
		void InOrder();
		void insert(int data);

};


//public 
void BinTree::InOrder() {
	InOrder(root);
	cout<<endl;
}

//private 
void BinTree::InOrder(BinTreeNode *t) {

//	cout<<"inOrder t:"<<t<<endl;

	if(t!=NULL) {
		InOrder(t->left);
		cout<<t->data<<" ";
		InOrder(t->right);
	}
}


void BinTree::CreateTree(int len) {
	pos = 0;
	this->len = len;
	root = NULL;
	CreateBinTree();
}

void BinTree::insert(int data) {
	BinTreeNode*t = root;
	int num = 100;
	while(num--) {//advoid dead loop
		//insert right
		if(data>t->data && t->right == NULL) {
//				cout<<"insert right:"<<data<<endl;
			t->right = new BinTreeNode();
			t->right->data = data;
//				cout<<"new t right:"<<t->right<<endl;
			break;
		}

		//insert left
		if(data<t->data && t->left == NULL) {
//				cout<<"insert left:"<<data<<endl;
			t->left = new BinTreeNode();
			t->left->data = data;
//				cout<<"new t left:"<<t->left<<endl;
			break;
		}

		//no insert
		t = (data>t->data)?t->right:t->left;

	}

	if(num==0) {
		cout<<"ERROR: while dead"<<endl;
	}
}

void BinTree::CreateBinTree() {
	int i,data;

	data = treeAr[0];
	if(root==NULL) {
//		cout<<"new root,data ="<<data<<endl;
		root = new BinTreeNode();
		root->data = data;
	}
//	cout<<"len:"<<len<<endl;
	for(i=1; i<len; i++) {
		data = treeAr[i];
		insert(data);
	}

}


int main() {
	BinTree * bin;
	int i,j,t,n,m,data;
	cin>>t;
	while(t--) {
		bin = new BinTree();
		cin>>n;
		bin->treeAr = new int[n]();
		for(i = 0; i<n; i++) {
			cin>>bin->treeAr[i];
		}
		//bulid tree
		bin->CreateTree(n);
		bin->InOrder();

		cin>>m;//insert
		while(m--) {
			cin>>data;
			bin->insert(data);
			bin->InOrder();
		}

	}

//	delete [] bin;
	return 0;
}

